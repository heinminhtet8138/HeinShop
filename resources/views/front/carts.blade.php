@extends('layouts.front')
@section('content')

    <div class="container my-5 py-5">
        <h3 class="text-center py-3">My Shopping Carts</h3>
        <div class="table-responsive">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th>Item Image</th>
                        <th>Item Price</th>
                        <th>Item Discount</th>
                        <th>Qty</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>

        <div class="d-grid gap-2">
            @guest 
                <a href="/login" class="btn btn-primary">Login</a>
            @else 
                <form id="paymentForm" class="row" enctype="multipart/form-data">
                    @csrf 
                    <div class="col-md-6">
                        <label for="payment_slip">Payment Slip</label>
                        <input type="file" name="payment_slip" id="payment_slip" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="payment_method">Payment method</label>
                        <select name="payment_method" id="payment_method" class="form-select">
                            <option value="">Choose payment method</option>
                            @foreach($payments as $payment)
                                <option value="{{$payment->id}}">{{$payment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="address">Address</label>
                        <textarea name="address" id="" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-success my-3" id="order-now" type="submit">Order Now</button>
                </form>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            // ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $('#order-now').click(function(){
            //     let itemString = localStorage.getItem('shops');
            //     $.post("{{route('orderNow')}}",{data:itemString},function(response){
            //         console.log(response);
            //     })
            // })

           $('#paymentForm').on('submit',function(e){
                e.preventDefault();
                var formData = new FormData(this);
                console.log(formData);

                let itemString = localStorage.getItem('shops');
                formData.append('orderItems',itemString);
            //  processData: false,
            //contentType: false, 
            // ဒီနှစ်ခုက Form Data သယ်ဖို့ 
                $.ajax({
                    type: 'POST',
                    url: "{{route('orderNow')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if(response){
                            alert('Order Successful');
                            localStorage.clear('shops');
                            location.href = '/';
                        }
                    }

                })
                
           })

        })
    </script>
@endsection