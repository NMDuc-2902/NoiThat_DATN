<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\log;
use App\Models\material;
use App\Models\picture;
use App\Models\product;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Backend\Http\Data\DataType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{

    public function index()
    {
        $title = "Products";
        $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $Products = product::where('status', '!=', DataType::DELETED_DATA_TYPE)->get();
        $materials = material::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $suppliers = supplier::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.index', ['title' => $title, 'products' => $Products, 'types' => $types, 'materials' => $materials, 'suppliers' => $suppliers]);
    }

    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->category_id = $request->input('type');
        $product->price = $request->input('price');
        $product->material_id = $request->input('material');
        $product->stock = $request->input('stock');
        $product->status = DataType::NORMAL_DATA_TYPE;
        
        $size = [
            'height' => $request->input('height') ?? 0,
            'length' => $request->input('length') ?? 0,
            'width' => $request->input('width') ?? 0,
        ];
        $product->content = json_encode(['size' => $size]);
        $product->description = $request->input('description');
    
        $product->save();

        $log = new log();
        $log->user_create = Auth::user()->id;
        $log->product_id = $product->id;
        $log->supplier_id = $request->input('supplier');
        $log->description = 'first import; Quantity = ' . $request->input('stock');
        $log->save();
    
        return redirect()->route('admin-product-edit', ['id' => $product->id])->with('success');
    }

    public function edit($id)
    {
        $product = product::find($id);
        if (!$product || $product->status === DataType::DELETED_DATA_TYPE) {
            throw new NotFoundHttpException();
        }
        $materials = material::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $images = picture::where('product_id', $id)->where('status', DataType::NORMAL_DATA_TYPE)->get();
        $suppliers = supplier::where('status', DataType::NORMAL_DATA_TYPE)->get();

        $logs = log::where('product_id', $id)->get();

        $title = "Edit Product";
        $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.edit', ['title' => $title, 'product' => $product, 'types' => $types, 'materials' => $materials, 'images' => $images, 'logs' => $logs, 'suppliers' => $suppliers]);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product || $product->status === DataType::DELETED_DATA_TYPE) {
                return response()->json(['error' => 'Product not found or deleted'], 404);
            }
        
            $changes = [];
            $fields = ['name', 'description', 'price', 'stock', 'sale_percentage' => 'sale'];
            
            // Check and record changes for regular fields
            foreach ($fields as $field => $input) {
                if (is_int($field)) {
                    $field = $input;
                }
                $newValue = $request->input($input);
                if ($newValue !== null && $product->$field != $newValue) {
                    $changes[] = ucfirst($field) . " changed from " . $product->$field . " to " . $newValue;
                    $product->$field = $newValue;
                }
            }
        
            // Check and record changes for category_id
            $newCategoryId = $request->input('type');
            if ($newCategoryId !== null && $product->category_id != $newCategoryId) {
                $oldCategoryName = $product->category->name;
                $newCategoryName = Category::find($newCategoryId)->name;
                $changes[] = "Category changed from " . $oldCategoryName . " to " . $newCategoryName;
                $product->category_id = $newCategoryId;
            }
        
            // Check and record changes for material_id
            $newMaterialId = $request->input('material');
            if ($newMaterialId !== null && $product->material_id != $newMaterialId) {
                $oldMaterialName = $product->material->name;
                $newMaterialName = Material::find($newMaterialId)->name;
                $changes[] = "Material changed from " . $oldMaterialName . " to " . $newMaterialName;
                $product->material_id = $newMaterialId;
            }
        
            // Check and record changes for size
            $content = json_decode($product->content, true);
            $sizes = ['height', 'length', 'width'];
            foreach ($sizes as $size) {
                $newSize = $request->input($size);
                if ($newSize !== null && $content['size'][$size] != $newSize) {
                    $changes[] = ucfirst($size) . " changed from " . ($content['size'][$size] ?? 0) . " to " . $newSize;
                    $content['size'][$size] = $newSize;
                }
            }
            $product->content = json_encode($content);
            $product->save();
        
            // Log changes if any
            if (!empty($changes)) {
                $log = new Log();
                $log->user_create = Auth::user()->id;
                $log->product_id = $product->id;
                $log->description = 'Edit product: ' . implode('; ', $changes);
                $log->save();
            }
        
            return response()->json(['success' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the product'], 500);
        }
    }
    
    public function upThumbnail(Request $request, $id)
    {
        $disk = 'uploads';
        $directory = 'images/product';
        
        $product = product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    
        if ($request->hasFile('image')) {
            $filePath = $this->storeImage($request->file('image'), $disk, $directory);
            
            $content = json_decode($product->content, true);
            if (!is_array($content)) {
                $content = [];
            }
    
            $content['imgThumbnail'] = $filePath;
    
            $product->content = json_encode($content);
            $product->save();
    
            return response()->json(['success' => true, 'path' => $filePath]);
        }
    
        return response()->json(['success' => false, 'message' => 'No images have been uploaded.']);
    }
    
    public function uploadImages(Request $request, $id)
    {
        $disk = 'uploads';
        $directory = 'images/product';
        
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    
        if ($request->hasFile('file')) {
            $filePath = $this->storeImage($request->file('file'), $disk, $directory);
            
            Picture::create([
                'product_id' => $id,
                'image' => $filePath,
                'status' => DataType::NORMAL_DATA_TYPE,
            ]);
    
            return response()->json(['success' => true, 'path' => $filePath]);
        }
    
        return response()->json(['success' => false, 'message' => 'No images have been uploaded.']);
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            $image = Picture::find($id);
            if (!$image || $image->status === DataType::DELETED_DATA_TYPE) {
                return response()->json(['error' => 'Image not found or already deleted'], 404);
            }
            $image->status = DataType::DELETED_DATA_TYPE;
            $image->save();

            $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
            $images = Picture::where('product_id', $image->product_id)->where('status', DataType::NORMAL_DATA_TYPE)->get();
            $product = Product::find($image->product_id);
            $materials = Material::where('status', DataType::NORMAL_DATA_TYPE)->get();

            $html = view('backend::product.table.imagelist', [
                'images' => $images,
                'product' => $product,
                'types' => $types,
                'materials' => $materials
            ])->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the image'], 500);
        }
    }

    private function storeImage($file, $disk, $directory)
    {
        if (!Storage::disk($disk)->exists($directory)) {
            Storage::disk($disk)->makeDirectory($directory);
        }
    
        $randomFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($directory, $randomFileName, $disk);
        return $disk . '/' . $filePath;
    }

    public function productState(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
    
            $product->status = ($product->status == 'normal') ? 'locked' : 'normal';
            $product->save();
    
            return redirect()->back()->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the product'], 500);
        }
    }

    public function deleteProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if ($product->stock != 0) {
                return response()->json(['error' => 'Product cannot be deleted as it still has stock'], 400);
            }
    
            $product->status = DataType::DELETED_DATA_TYPE;
            $product->deleted_at = Carbon::now();
            $product->save();
    
            return redirect()->route('admin-product-index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }

    public function importing($id, Request $request){
        try {
            $product = Product::findOrFail($id);
            $product->stock = $product->stock + $request->input('quantity');
            $product->save();

            $log = new log();
            $log->user_create = Auth::user()->id;
            $log->product_id = $product->id;
            $log->supplier_id = $request->input('supplier');
            $log->description = 'import more goods; Quantity = ' . $request->input('quantity');
            $log->save();
    
            return redirect()->route('admin-product-index')->with('success', 'Product importing successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }

    public function detailLog($id){
        try{
            $log = log::findOrFail($id);
            return response()->json([
                'log' => $log,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }
}
