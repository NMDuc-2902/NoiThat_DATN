@extends('backend::base')
@section('script')
    <script>
        $(document).ready(function() {
            function attachIconSelectionHandlers(modal) {
                $(modal).find('#show-icon-grid').on('click', function() {
                    $(modal).find('#icon-grid').show();
                });

                $(modal).find('.icon-cell').on('click', function() {
                    $(modal).find('.icon-cell').removeClass('selected');
                    $(this).addClass('selected');
                    var iconClass = $(this).data('icon');
                    $(modal).find('#selected-icon').val(iconClass);
                    $(modal).find('#icon-grid').hide();
                    
                    // Display the selected icon
                    $(modal).find('#selected-icon-display').html('<i class="f-icon ' + iconClass + '"></i>');
                });
            }

            $('#bd-example-modal-lg').on('shown.bs.modal', function() {
                attachIconSelectionHandlers(this);
            });

            $('#modalEdit').on('shown.bs.modal', function() {
                attachIconSelectionHandlers(this);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#productSearch').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('#productList .product-card-container').each(function() {
                    var productName = $(this).find('.product-details span').attr('title').toLowerCase();
                    if (productName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
    
            $('.product-card').click(function() {
                var checkbox = $(this).find('input[type="checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));
                $(this).toggleClass('selected');
            });
    
            $('#thumbnail').change(function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumbnailImage').attr('src', e.target.result);
                    $('#thumbnailPreview').show();
                };
                reader.readAsDataURL(this.files[0]);
            });
    
            $(document).on('click', '.openModalEdit', function(e) {
                e.preventDefault();
                var categoryId = $(this).data('category-id');
                var url = $(this).data('url');
                
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        var content = JSON.parse(data.content);
                        $('#modalEdit input[name="name"]').val(data.name);
                        $('#modalEdit select[name="type"]').val(data.type);
                        $('#selected-icon-display').html('<i class="f-icon ' + content.icon + '"></i>');
                        $('#edit_category_form').attr('action', '/admin/categories/update/' + categoryId);
                        
                        if (data.type == 'Rooms') {
                            $('#productSection').show();
                        } else {
                            $('#productSection').hide();
                        }

                        if (content.imgThumbnail) {
                            var thumbnailImage = $('#thumbnailImage');
                            thumbnailImage.attr('src', content.imgThumbnail);
                            $('#thumbnailPreview').show();
                        } else {
                            $('#thumbnailImage').attr('src', '');
                            $('#thumbnailPreview').hide();
                        }

                        if (content.hasOwnProperty('products')) {
                            var selectedProductIds = JSON.parse(content.products);
                            $('#productSection .product-card').each(function() {
                                var productId = $(this).data('product-id');
                                if (selectedProductIds.includes(productId.toString())) {
                                    $(this).find('input[type="checkbox"]').prop('checked', true);
                                    $(this).addClass('selected');
                                }
                            });
                        } else {
                            $('#productSection .product-card input[type="checkbox"]').prop('checked', false);
                            $('#productSection .product-card').removeClass('selected');
                        }
                        
                        $('#modalEdit').modal('show');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#delete-category', function(e) {
                e.preventDefault();

                var categoryId = $(this).data('id');
                var deleteUrl = '{{ route("admin-category-deleted", ":id") }}';
                deleteUrl = deleteUrl.replace(':id', categoryId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: deleteUrl,
                            success: function(response) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Category deleted successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                var response = xhr.responseJSON;

                                if (response && response.error) {
                                    Swal.fire(
                                        'Error!',
                                        response.error,
                                        'error'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Please try again later.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>


    
@endsection
@section('content')
<div id="list-table-category">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Categories</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin-dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Categories
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::Category.table.table-category')
        </div>
    </div>
</div>
@endsection
