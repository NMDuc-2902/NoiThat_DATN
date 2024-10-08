<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Add category
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_category_form" action="{{route('admin-category-store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" required style="margin-bottom: 15px;" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="address" style="font-weight: bold;">Type <span style="color: red;">*</span></label>
                        <select class="form-control" name="type" required>
                            @foreach($types as $type)
                                <option value="{{ $type['value'] }}">{{ $type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <div class="select-icon-container">
                                <button type="button" id="show-icon-grid" class="btn btn-primary">Select Icon</button>
                                <div id="selected-icon-display" style="margin-left: 10px;"></div>
                            </div>
                            <div id="icon-grid" style="display: none; margin-top: 10px; max-height: 300px; overflow-y: auto;">
                                <div class="icon-grid-container">
                                    @foreach($icons as $icon)
                                        <div class="icon-cell" data-icon="{{ $icon['class'] }}">
                                            <i class="f-icon {{ $icon['class'] }}"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <input type="hidden" id="selected-icon" name="icon" required>
                        </div>                            
                    </div>
                </div>

                <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-modal-category">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>