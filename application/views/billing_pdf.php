<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            background: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 2px solid #ddd;
        }

        h3 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #4B49AC;
            color: white;
        }

        .summary {
            max-width: 300px;
            float: right;
            text-align: right;
            margin-top: 20px;
            background: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            clear: both;
        }

        .summary table {
            width: 100%;
            border: none;
        }

        .summary td {
            border: none;
            text-align: right;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: #d9534f;
        }

        .contact {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            padding: 10px;
            font-size: 14px;
            color: #555;
            border-top: 2px solid #ddd;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/images/logo.svg'); ?>" alt="Logo" style="width:200px">
            <h2>Payment Reciept</h2>
        </div>
        <div class="info">
            <p><strong>Receipt No:</strong> <?= $sale->invoice_no; ?></p>
            <p><strong>Date:</strong> <?= date('d M, Y', strtotime($sale->created_at)); ?></p>
        </div>

        <h3>Sale Items</h3>
        <?php if (!empty($sales_items)) : ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($sales_items as $item) : ?>
                    <tr>
                        <td><?= $item['product_name']; ?></td>
                        <td><?= $item['quantity']; ?></td>
                        <td><?= number_format($item['price'], 2); ?></td>
                        <td><?= number_format($item['total'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p style="text-align: center; color: red;">No items found for this sale.</p>
        <?php endif; ?>

        <div class="summary">
            <table>
                <tr>
                    <td><strong>SubTotal:</strong></td>
                    <td><strong>RS.<?= number_format($sale->total_amount, 2); ?></strong></td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td><?= number_format($sale->discount, 2); ?></td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td><?= number_format($sale->tax, 2); ?></td>
                </tr>
                <tr>
                    <td class="total"><strong>Grand Total:</strong></td>
                    <td class="total">RS.<?= number_format($sale->final_amount, 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for shopping with us! Your support means the world to us. We hope to see you again soon!</p>
        </div>
    </div>
</body>

</html>
