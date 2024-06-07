<div class="tab-pane fade" id="contact2" role="tabpanel">
    <div class="pd-20">
        <div class="pd-20">
            <div class="card-box pb-10">
                <table id="dataTableProductDetail" class="data-table table nowrap">
                    <thead>
                        <tr style="text-align: center">
                            <th class="table-plus">Name</th>
                            <th>Type</th>
                            <th>Sale</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($products as $product)
                        @php
                            $content = json_decode($product->content)
                        @endphp
                        <tr>
                            <td class="table-plus">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        @if (isset($content->imgThumbnail))
                                            <img
                                                src="{{ asset($content->imgThumbnail) }}"
                                                width="40"
                                                height="40"
                                                alt="Product Thumbnail"
                                            />
                                        @else
                                            <img
                                                src="{{ asset('backend/src/images/image-clone.svg')}}"
                                                width="40"
                                                height="40"
                                                alt="Default Thumbnail"
                                            />
                                        @endif
                                    </div>
                                    <div class="txt">
                                        <div class="weight-600">{{$product->name}}</div>
                                    </div>
                                </div>
                            </td>
                
                            <td style="text-align: center">
                                {{$product->type->name ?? 'N/A'}}
                            </td>
                            <td style="text-align: center">
                                {{$product->sale ?? 'N/A'}}
                            </td>
                            <td style="text-align: center">
                                @if ($product->status == 'normal')
                                    <span class="badge badge-success">
                                        {{$product->status}}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        {{$product->status}}
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <a href="{{route('admin-product-edit', ['id' => $product->id])}}" style="color: #265ed7; margin-right: 10px;">
                                    <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                                </a>
                                <a href="{{route('admin-product-delete', ['id' => $product->id])}}" id="delete-product" style="color: #ff0000; margin-right: 10px;">
                                    <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                                </a>
                                @if ($product->locked == 'normal')
                                    <a href="{{route('admin-product-state', ['id' => $product->id])}}" id="lock-product" style="color: #ff0000; margin-right: 10px;">
                                        <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                                    </a>
                                @else
                                    <a href="{{route('admin-product-state', ['id' => $product->id])}}" id="lock-product" style="color: #00ff3381; margin-right: 10px;">
                                        <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>