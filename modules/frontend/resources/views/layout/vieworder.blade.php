@extends('frontend::main')
@section('content')
    <!-- ========================  Main header ======================== -->

    <section class="main-header" style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg)') }}">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="#">Order</a></li>
                </ol>
            </div>
        </header>
    </section>


    <!-- ========================  Checkout ======================== -->

    <section class="checkout">
        <div class="container">

            <header class="hidden">
                <h3 class="h3 title">Checkout - Step 4</h3>
            </header>

            <!-- ========================  Cart navigation ======================== -->

            <div class="clearfix">
                <div class="row">
                    <div class="col-xs-6">
                        <span class="h2 title">Your order is completed!</span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="/" class="btn btn-main"><span class="icon icon-home"></span> Home</a>
                        <a onclick="window.print()" class="btn btn-main"><span class="icon icon-printer"></span> Print</a>
                    </div>
                </div>
            </div>

            <!-- ========================  Payment ======================== -->

            <div class="cart-wrapper">

                <div class="note-block">

                    <div class="row">
                        <!-- === left content === -->

                        <div class="col-md-6">

                            <div class="white-block">

                                <div class="h4">Shipping info</div>

                                <hr />

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Name</strong> <br />
                                            <span>{{ $Invoices->name }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Email</strong><br />
                                            <span>{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Phone</strong><br />
                                            <span>{{ $Invoices->phone }}</span>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <strong>Address</strong><br />
                                            <span>{{ $Invoices->address }}</span>
                                        </div>
                                    </div>

                                </div>

                            </div> <!--/col-md-6-->

                        </div>

                        <!-- === right content === -->

                        <div class="col-md-6">
                            <div class="white-block">

                                <div class="h4">Order details</div>

                                <hr />

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Order no.</strong> <br />
                                            <span>#mobel{{ $Invoices->id }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Transaction ID</strong> <br />
                                            <span>#mobel{{ $Invoices->pay->id }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Order date</strong> <br />
                                            <span>{{ $Invoices->invoice_date }}</span>
                                        </div>
                                    </div>
                                    @php
                                        $currentDate = new DateTime($Invoices->invoice_date);

                                        // Ngày bắt đầu (hiện tại + 3 ngày)
                                        $startDate = clone $currentDate;
                                        $startDate->add(new DateInterval('P3D'));

                                        // Ngày kết thúc (hiện tại + 7 ngày)
                                        $endDate = clone $currentDate;
                                        $endDate->add(new DateInterval('P7D'));

                                        // Định dạng ngày
                                        $startDateFormatted = $startDate->format('Y-m-d');
                                        $endDateFormatted = $endDate->format('Y-m-d');
                                    @endphp

                                    @if ($Invoices->delivery == 'Store')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Note</strong></br>
                                                <span>You can come to the store any day of the week to pick up your
                                                    order.</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Received date</strong> <br />
                                                <span>{{ $startDateFormatted }} - {{ $endDateFormatted }}</span>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <div class="h4">Payment details</div>

                                <hr />
                                @if ($Invoices->pay->name == 'COD')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Payment</strong><br />
                                                <span>{{ $Invoices->pay->name }}<small>
                                                        ({{ $Invoices->pay->description }})</small></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Order time</strong> <br />
                                                <span>{{ $Invoices->pay->created_at }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Amount</strong><br />
                                                <span>$ {{ $Invoices->total }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Payment</strong><br />
                                                <span>{{ $Invoices->pay->name }}<small>
                                                        ({{ $Invoices->pay->description }} -
                                                        {{ $Invoices->pay->notes }})</small></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Amount</strong><br />
                                                <span>$ {{ $Invoices->total }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Order time</strong> <br />
                                                <span>{{ $Invoices->pay->created_at }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Transaction time</strong><br />
                                                <span>{{ $Invoices->pay->processing_time }}</span>
                                            </div>
                                        </div>

                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================  Cart wrapper ======================== -->

            <div class="cart-wrapper">
                <!--cart header -->

                <div class="cart-block cart-block-header clearfix">
                    <div>
                        <span>Product</span>
                    </div>
                    <div>
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>Quantity</span>
                    </div>
                    <div class="text-right">
                        <span>Price</span>
                    </div>
                </div>

                <!--cart items-->

                <div class="clearfix">
                    @foreach ($items as $c)
                        <div class="cartItemCheck">
                            <div class="cart-block cart-block-item clearfix" data-id="{{ $c->id }}">
                                <div class="image">
                                    @php
                                        $contentArray = json_decode($c->content, true);
                                        $imgThumbnail =
                                            $contentArray['imgThumbnail'] ?? 'frontend/assets/images/product-1.png';
                                    @endphp
                                    <a href="/productdetail/{{ $c->id }}">
                                        <img src="{{ asset($imgThumbnail) }}" alt="" />
                                    </a>
                                </div>
                                <div class="title">
                                    <div class="h4"><a
                                            href="/productdetail/{{ $c->id }}">{{ $c->name }}</a>
                                    </div>
                                    {{-- <div>Green corner</div> --}}
                                </div>
                                <div class="quantity">
                                    <input type="hidden" value="{{ $c->quantity }}" class="form-control form-quantity"
                                        min="1" max="3" data-price="{{ $c->price }}"
                                        data-sale="{{ $c->sale_percentage ?? 0 }}" oninput="updateCartItem(this)">
                                    </input>
                                    <Label>{{ $c->quantity }}</Label>
                                </div>
                                <div class="price">
                                    @if (isset($c->sale_percentage))
                                        <span class="final h3">$
                                            {{ $c->price - $c->price * ($c->sale_percentage * 0.01) }}</span>
                                        <span class="discount">$ {{ $c->price }}</span>
                                    @else
                                        <span class="final h3">$ {{ $c->price }}</span>
                                    @endif
                                </div>
                                {{-- <span class="icon icon-cross icon-delete" data-id="{{ $c->id }}"></span> --}}
                            </div>
                        </div>
                    @endforeach

                    <!--cart prices -->
                    </br>

                    <div class="clearfix">
                        <div class="cart-block cart-block-footer clearfix">
                            <div>
                                <strong>Total</strong>
                            </div>
                            <div>
                                <span>$ {{ $totalPrice }}</span>
                            </div>
                        </div>
                        <div class="cart-block cart-block-footer clearfix">
                            @if (isset($discountMoney))
                                <div>
                                    <strong>Discount </strong>
                                </div>
                                <div>
                                    <span> - $ {{ $discountMoney }}</span>
                                </div>
                            @else
                                <div>
                                    <strong>Discount</strong>
                                </div>
                                <div>
                                    <span> 0</span>
                                </div>
                            @endif
                        </div>

                        <div class="cart-block cart-block-footer clearfix">
                            <div>
                                <strong>Shipping</strong>
                            </div>
                            <div>
                                <span>Free</span>
                            </div>
                        </div>
                    </div>

                    <!--cart final price -->
                    <div class="clearfix">
                        <div class="cart-block cart-block-footer clearfix">
                            <div>
                                <strong class="h4">Final price</strong>
                            </div>
                            <div>
                                <div class="h4 title">$ {{ $Invoices->total }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================  Cart navigation ======================== -->

            <div class="clearfix">
                <div class="row">
                    <div class="col-xs-6">
                        <span class="h2 title">Your order is completed!</span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="/" class="btn btn-main"><span class="icon icon-home"></span> Home</a>
                        <a onclick="window.print()" class="btn btn-main"><span class="icon icon-printer"></span>
                            Print</a>
                    </div>
                </div>
            </div>

        </div> <!--/container-->

    </section>
@endsection
