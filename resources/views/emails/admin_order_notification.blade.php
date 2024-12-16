<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <h1>New Order Created</h1>
    <p>A new order (ID: {{ $order->id }}) has been created by {{ $order->name }}.</p>
    <p>Total Amount: {{ $order->grand_total }}</p>
</body>
</html>
