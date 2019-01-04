<html>
<head>
    <meta charset="ISO-8859-1">
    <style>

        html, body {
            width: 23cm; /* was 907px */
            height: 13.5cm; /* was 529px */
            display: block;
            font-family: "Consolas";
            margin:0;
            /*font-size: auto; NOT A VALID PROPERTY */
        }
        table{
            width:100%;
            display:inline;
            font-size:13px;
        }
        .box-body{
            padding:10px;
            font-size:13px;
        }
        @media print {
            html, body {
                width: 23cm; /* was 8.5in */
                height: 13.5cm; /* was 5.5in */
                display: block;
                font-family: "Consolas";
                padding:0 10px;
                margin:0;
                /*font-size: auto; NOT A VALID PROPERTY */
            }
            table{
                width:100%;
                display:inline;
                font-size:13px;
            }
            .box-body{
                padding:10px;
                font-size:13px;
            }

            @page {
                size: 24cm 14cm /* . Random dot? */;
            }
        }
    </style>
</head>
<body>
    <div class="box-body">
        <table style="display:inline;">
            <thead>
                <tr>
                    <td style="width:350px;">Kepada Yth:</td>
                    <td style="width:200px;">Kode Transaksi</td>
                    <td style="width:200px;">: <?php echo $details[0]->id_stransaction;?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $details[0]->calling." ".$details[0]->customer_name;?></td>
                    <td>Tgl Pembelian</td>
                    <td>: <?php echo date("d-m-Y H:i:s",strtotime($details[0]->created_at));?></td>
                </tr>
                <tr>
                    <td><?php echo $details[0]->customer_address;?> </td>
                    <td valign="top">Pembayaran</td>
                    <td valign="top">: <?php echo $details[0]->is_cash == 1 ? "Tunai" : "Kredit";?></td>
                </tr>
                <tr>
                    <td>Telephon: <?php echo $details[0]->customer_phone;?></td>
                    <td valign="top">Jatuh Tempo</td>
                    <td valign="top">: <?php echo $details[0]->is_cash == 1 ? "-" : $details[0]->pay_deadline_date;?></td>
                </tr>
            </tbody>
        </table>
        <br />
        <?php $line = "==================================================================================================================";?>
        <?php echo $line;?>
        <table>
            <thead>
            <tr>
                <td style="width:70px;">Kode</td>
                <td style="width:160px;">Produk</td>
                <td style="width:100px;">Kategori</td>
                <td style="width:100px;">Jumlah</td>
                <td style="width:200px;">Harga/Item</td>
                <td style="width:100px;">Subtotal</td>
            </tr>
            </thead>
        </table>
        <?php echo $line;?>
        <table>
            <thead  style="height:270px;">
            <?php if(isset($details) && is_array($details)){ ?>
                <?php foreach($details as $key => $transaksi){?>
                    <tr valign="top" style="height:10px;font-size:14px;">
                        <td style="width:70px;"><?php echo $transaksi->id_online;?></td>
                        <td style="width:160px;"><?php echo $transaksi->product_name;?></td>
                        <td style="width:100px; text-align: left;"><?php echo $transaksi->category_name;?></td>
                        <td style="width:100px; text-align: left;"><?php echo $transaksi->data_qty;?></td>
                        <td style="width:200px; text-align: left;">Rp <?php echo number_format($transaksi->price_item);?>,-</td>
                        <td style="width:100px; text-align: left;">Rp <?php echo number_format($transaksi->subtotal);?>,-</td>
                    </tr>
                <?php } ?>
                <?php $total = 8 - ($key + 1);
                for($a =1; $a <= $total; $a++){ ?>
                    <tr style="height:10px;font-size:14px;">
                        <td style="width:70px;"></td>
                        <td style="width:160px;"></td>
                        <td style="width:100px;"></td>
                        <td style="width:100px;"></td>
                        <td style="width:200px;"></td>
                        <td style="width:100px;"></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </thead>
        </table>
        <?php echo $line;?>
        <table>
            <thead>
            <tr>
                <td style="width:160px;"></td>
                <td style="width:100px;"></td>
                <td style="width:100px;"></td>
                <td style="width:200px;">Total Pembelian</td>
                <td style="width:100px;text-align: right;">Rp <?php echo number_format($transaksi->total_price);?>,-</td>
            </tr>
            <tr>
                <td style="width:160px;"></td>
                <td style="width:100px;"></td>
                <td style="width:100px;"></td>
                <td style="width:200px;">Ongkos Kirim</td>
                <td style="width:100px;text-align: right;">Rp <?php echo number_format($ongkir);?>,-</td>
            </tr>
            <tr>
                <td style="width:160px;"></td>
                <td style="width:100px;"></td>
                <td style="width:100px;"></td>
                <td style="width:200px;">Total Biaya</td>
                <td style="width:100px;text-align: right;">Rp <?php echo number_format($transaksi->total_price+$ongkir);?>,-</td>
            </tr>
            </thead>
        </table>
        <?php echo $line;?>
        <br />
        <table>
            <thead>
            <tr>
                <td style="width:300px;text-align: center;">Pembeli</td>
                <td style="width:300px;text-align: center;">Pengantar</td>
                <td style="width:300px;text-align: center;">Hormat Kami</td>
                <!--<td style="width:350px;text-align: center;">**Terimakasih**</td>-->
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="height:50px;"></td>
                <td style="height:50px;"></td>
                <td style="height:50px;"></td>
            </tr>
            <tr>
                <td style="text-align: center;">(.............)</td>
                <td style="text-align: center;">(.............)</td>
                <td style="text-align: center;">(.............)</td>
                <!--<td style="width:342px;text-align: center;">dan elektronik</td>-->
            </tr>
            </tbody>
        </table>
        <?php echo $line;?>
        <br />
        <br />
        <table style="display:inline;">
            <thead>
                <tr>
                    <td style="width:350px;">Kepada Yth:</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $details[0]->calling." ".$details[0]->customer_name;?></td>
                </tr>
                <tr>
                    <td><?php echo $details[0]->customer_address;?> </td>
                </tr>
                <tr>
                    <td>Telephon: <?php echo $details[0]->customer_phone;?></td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <?php echo $line;?>
        <br />
        <br />
        <table style="display:inline;">
            <tbody>
                <tr>
                    <td>Pengirim</td>
                    <td>: Rida Ristanto</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: Tambak Boyo No. 50 RT 026/RW 061, Condong Catur, Depok, Sleman, Yogyakarta 55283</td>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td>: +628562938548</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td>: www.kaosufc.com , www.grosirtutorial.com</td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <?php echo $line;?>
    </div>
</body>
</html>