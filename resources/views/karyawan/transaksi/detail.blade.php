@extends('karyawan.layouts.layout')
@section('title','Detail Transaksi')
@section('content')

<div class="">

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <section class="content invoice">

                        <div class="row">
                            <div class="  invoice-header">
                                <h1>
                                    TRX-3284732
                                </h1>
                            </div>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>Iron Admin, Inc.</strong>
                                    <br>795 Freedom Ave, Suite 600
                                    <br>New York, CA 94107
                                    <br>Phone: 1 (804) 123-9876
                                    <br>Email: ironadmin.com
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>John Doe</strong>
                                    <br>795 Freedom Ave, Suite 600
                                    <br>New York, CA 94107
                                    <br>Phone: 1 (804) 123-9876
                                    <br>Email: jon@ironadmin.com
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #007612</b>
                                <br>
                                <br>
                                <b>Order ID:</b> 4F3S8J
                                <br>
                                <b>Payment Due:</b> 2/22/2014
                                <br>
                                <b>Account:</b> 968-34567
                            </div>

                        </div>


                        <div class="row">
                            <div class="  table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Serial #</th>
                                            <th style="width: 59%">Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1sfgs</td>
                                            <td>Call of Duty</td>
                                            <td>455-981-221</td>
                                            <td>El snort testosterone trophy driving gloves handsome
                                                gerry Richardson helvetica tousled street art master
                                                testosterone trophy driving gloves handsome gerry
                                                Richardson
                                            </td>
                                            <td>$64.50</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <p class="lead">Payment Methods:</p>
                                <img src="./Gentelella Alela! __files/visa.png" alt="Visa">
                                <img src="./Gentelella Alela! __files/mastercard.png" alt="Mastercard">
                                <img src="./Gentelella Alela! __files/american-express.png"
                                    alt="American Express">
                                <img src="./Gentelella Alela! __files/paypal.png" alt="Paypal">
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah
                                    plickers sifteo edmodo ifttt zimbra.
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p class="lead"></p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>PPN:</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Diskon:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="row no-print">
                            <div class=" ">
                            <form method="post" action="{{url('karyawan/admin/pendaftaran/siswa/konfirmasi')}}">
                            @csrf
                            <input type="hidden" name="transaksi" vlaue="{{$Pembayaran[0]->KodeTransaksi}}">
                                <button type="submit" class="btn btn-success pull-right"><i
                                        class="fa fa-credit-card"></i>Konfirmasi</button>
                            </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection