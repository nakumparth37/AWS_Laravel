<?php
$order = $data;
// return $order;
// $order = [
//     "UserName" => "Parth Nakum",
//     "address" => "167, Old Faridabad Chowk, Mathura Rd Main Road,Jamanager,Gujarat,India 361007",
//     "User_contact" => "9328814813",
//     "paymentMode" => "UPI",
//     "transaction_id" => '56464654654asddasdaad4a4',
//     "OrderProductDetails" => [
//         [
//             "id" => 102,
//             "title" => "Samsung Galaxy S23 Ultra",
//             "description" => "Samsung Galaxy S23 Ultra ; OS, Android 13, One UI 5.1 ; Chipset, Qualcomm SM8550-AC Snapdragon 8 Gen 2 (4 nm) ; CPU, Octa-core (1x3.36 GHz Cortex-X3 & 2x2.8 GHz",
//             "price" => 1500,
//             "discountPercentage" => 10.58,
//             "rating" => "5.00",
//             "stock" => 500,
//             "brand" => "Samsung",
//             "categoryId" => 1,
//             "thumbnail" => "http://192.168.103.51/uploads/Product/Product_102/thumbnail/mainS23_th.jpg",
//             "images" => "http://192.168.103.51/uploads/Product/Product_102/mainS23_th.jpg,http://192.168.103.51/uploads/Product/Product_102/NewS23_1.jpg,http://192.168.103.51/uploads/Product/Product_102/NewS23_2.webp,http://192.168.103.51/uploads/Product/Product_102/NewS23_3.webp,http://192.168.103.51/uploads/Product/Product_102/NewS23_4.webp",
//             "created_at" => "2023-08-18 07:04:38",
//             "updated_at" => "2023-08-18 07:12:35",
//             "quantity" => 2,
//             "discountPrice" => 1451.3
//         ],
//         [
//             "id" => 6,
//             "title" => "MacBook Pro",
//             "description" => "MacBook Pro 2021 with mini-LED display may launch between September, November",
//             "price" => 1749,
//             "discountPercentage" => 11.02,
//             "rating" => "0",
//             "stock" => 83,
//             "brand" => "Apple",
//             "categoryId" => 2,
//             "thumbnail" => "https://i.dummyjson.com/data/products/6/thumbnail.png",
//             "images" => "https://i.dummyjson.com/data/products/6/1.png,https://i.dummyjson.com/data/products/6/2.jpg,https://i.dummyjson.com/data/products/6/3.png,https://i.dummyjson.com/data/products/6/4.jpg",
//             "created_at" => null,
//             "updated_at" => null,
//             "quantity" => 2,
//             "discountPrice" => 1556.26
//         ],

//     ],
//     "orderGroupID" => "ORDGROUPJCaONp8uWq679",
//     "created_at" => "2023-08-19T09:11:27.000000Z"
// ];

$orderData = $order['created_at'];
$totalPrice = 0;
?>
<div class="container">
    <div class="modal-body border m-2">
        <div class="row  align-items-center">
            <div class="col-6 d-flex justify-content-end flex-column">
                <h2 class="text-primary text-end"><br></h2>
                <div>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 50.0000%;">
                                    <h2 class="text-success"><strong><span style="font-size: 30px;color:rgb(244 ,67 ,54);">Invoice</span></strong>
                                    </h2><br>
                                </td>
                                <td style="width: 50%; text-align: right;">
                                    <h2 class="text-primary text-end"><span style="font-size: 30px;color:rgb(244 ,67 ,54);">E-commerce</span></h2>
                                    <div>E-commerce Inc&nbsp;<br>1600 Amphitheatre Parkway<br>India</div><br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col-6">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 50%; vertical-align: middle;">
                                <h4><span style="font-size: 26px;">{{$order['UserName']}}</span></h4>
                                <p>{{$order['address']}}</p><br>Payment Type&nbsp;<br>UPI<br>
                            </td>
                            <td style="width: 50%; text-align: right;">
                                <div>
                                    <h4><span style="font-size: 22px;">Invoice</span></h4>{{$order['orderGroupID']}}
                                    &nbsp;<br><br>Transaction id&nbsp;<br>{{$order['transaction_id']}}
                                    <br><br>Order Data&nbsp;<br>{{$orderData}}
                                </div><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="my-2">
        <h4 style="text-align: center;"><span style="font-size: 19px;">Order Summery</span></h4>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="width: 100%; border-collapse: collapse; border: 1px solid rgb(0, 0, 0);">
                    <thead class="table-dark">
                        <tr style="background-color:rgb(244, 67, 54);color:white;">
                            <th scope="col" style="width: 1.259%; text-align: center; " class="fr-cell-fixed ">
                                <p style="margin: 2px;">Items</p>
                            </th>
                            <th scope="col" style="width: 23.1434%; text-align: center; ">
                                <p style="margin: 6px;">Description</p>
                            </th>
                            <th scope="col" style="width: 15.4657%; text-align: center; ">
                                <p style="margin: 6px;">Price(MRP)</p>
                            </th>
                            {{-- <th scope="col" style="text-align: center;">
                                <p style="margin: 6px;">Discounted</p>
                            </th> --}}
                            {{-- <th scope="col" style="width: 23.1096%; text-align: center; ">
                                <p style="margin: 6px;">Discounted Price</p>
                            </th> --}}
                            <th scope="col" style="width: 8.7849%; text-align: center;">
                                <p style="margin: 6px;">Quantity</p>
                            </th>
                            <th scope="col" style="text-align: center;">
                                <p style="margin: 6px;">Amount</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order['OrderProductDetails'] as $key=>$productData)
                        <tr>
                            <td scope="row" style="width: 1.259%; text-align: center; border:1px  solid rgb(0, 0, 0);">{{$key +1}}</td>
                            <td class="text-truncate " style="width: 23.1434%; text-align: center; border: 1px solid rgb(0, 0, 0);">{{$productData['title']}}</td>
                            <td style="width: 15.4657%; text-align: center; border: 1px solid rgb(0, 0, 0);">${{$productData['price']}}</td>
                            {{-- <td class="text-danger " style="text-align: center; border: 1px solid rgb(0, 0, 0);color: red;"> - {{$productData['discountPercentage']}}%</td> --}}
                            {{-- <td class="text-success " style="width: 23.1096%; text-align: center; border: 1px solid rgb(0, 0, 0);color: green;">${{$productData['discountPrice']}}</td> --}}
                            <td class="fw-bold " style="width: 8.7849%; text-align: center; border:1px  solid rgb(0, 0, 0);font-weight: bold;"> x {{$productData['quantity']}}
                            </td>
                            <td class="fw-bold " style="text-align: center; border: 1px solid rgb(0, 0, 0);font-weight: bold;">${{$productData['price']*$productData['quantity']}}</td>
                        </tr>
                        <?php $totalPrice += $productData['price']  *  $productData['quantity'] ?>
                        @endforeach
                        <tr style="height:10px ;">
                            <td colspan="6"></td>
                        </tr>
                        <tr class="table-group-divider">
                            <td colspan="3" style="text-align: center; border: 1px solid rgb(0, 0, 0);">Total</td>
                            <td style="width: 23.1096%; text-align: center; border: 1px solid rgb(0, 0, 0);">${{$totalPrice}}</td>
                            <td class="text-end fr-cell-handler " rowspan="3" colspan="2" style="width: 19.5763%; text-align: center; border:3px  solid rgb(244, 67, 54)">
                                <h4 class="mt-3" style="color:rgb(244, 67, 54);margin: 0;">TOTAL</h4>
                                <h3 style="color:rgb(244 ,67 ,54);margin: 0;">${{$totalPrice + 14}}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center; border: 1px solid rgb(0, 0, 0);">Shipping</td>
                            <td style="width: 23.1096%; text-align: center; border: 1px solid rgb(0, 0, 0);">+ $0 &nbsp;<span style="color: green; font-weight:bold;">Free shipping</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center; border: 1px solid rgb(0, 0, 0);">Tax</td>
                            <td style="width: 23.1096%; text-align: center; border: 1px  solid rgb(0, 0, 0);">+ $14</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
