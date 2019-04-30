@extends('layouts.bst')

@section('content')
    <table class="table table-striped">
        <tr>
            <td>商品id</td>
            <td>商品名称</td>
            <td>商品价格</td>
        </tr>

            <tr>
                <td>{{$goods_id}}</td>
                <td>{{$goods_name}}</td>
                <td>{{$goods_price}}</td>
            </tr>


    </table>
@endsection