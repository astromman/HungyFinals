@extends('layouts.buyer.buyermaster')

@section('content')
<div class="content">
    <div class="shop-container">
        <h3 class="pt-2 text-center">Shopping Cart</h3>
        @if(empty($orders->at_cart))
        <div class="cart-wrapper text-center pt-5">
            <h3>Wala pang order si Klasmeyt.</h3>
            <!-- <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:50%">Product</th>
                        <th style="width:10%">Price</th>
                        <th style="width:8%">Quantity</th>
                        <th style="width:22%" class="text-center">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Walang order</td>
                    </tr>
                </tbody>
                <tfoot class="text-center">
                    <tr>
                        <td><a href=" route('shopmenu') " class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                        <td colspan="2" class="hidden-xs"></td>
                        <td class="hidden-xs text-center"><strong>Total $1.99</strong></td>
                        <td><a href="#" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
                    </tr>
                </tfoot>
            </table> -->
        </div>
        @else
        <div class="cart-wrapper">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:50%">Product</th>
                        <th style="width:10%">Price</th>
                        <th style="width:8%">Quantity</th>
                        <th style="width:22%" class="text-center">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add your products here -->
                </tbody>
                <tfoot>
                    <tr>
                        <td><a href=" route('shopmenu') " class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                        <td colspan="2" class="hidden-xs"></td>
                        <td class="hidden-xs text-center"><strong>Total $1.99</strong></td>
                        <td><a href="#" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif

    </div>
</div>

@endsection