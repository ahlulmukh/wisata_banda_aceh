<html>
<head>
   <style>
       .container {
           padding: 20px;
           border: 1px solid #ccc;
       }
       .header {
           font-weight: bold;
           margin-bottom: 10px;
       }
       .item {
           margin-bottom: 5px;
       }
   </style>
</head>
<body>
   <div class="container">
       <div class="header">Bukti Pembelian</div>
       <div class="item">Nomor Pesanan : {{ $order->id }}</div>
       <div class="item">Tanggal Pesanan : {{ $order->created_at }}</div>
       <div class="item">Nama Pembeli : {{ $order->nama }}</div>
       <div class="item">Jumlah Tiket : {{ $order->quantities }}</div>
       <div class="item">Total Harga : {{ $order->total_price }}</div>
       <div class="item">Status : BERHASIL</div>
       <!-- Tambahkan item lainnya sesuai dengan kebutuhan -->
   </div>
</body>
</html>
