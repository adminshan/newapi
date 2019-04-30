@extends('layouts.bst')

@section('content')
    <table class="table table-striped">
        <tr>
            <td>商品id</td>
            <td>商品名称</td>
            <td>商品价格</td>
        </tr>
        @foreach($list as $v)
            <tr>
                <td>{{$v['goods_id']}}</td>
                <td>{{$v['goods_name']}}</td>
                <td>{{$v['goods_price']}}</td>
            </tr>

        @endforeach
    </table>
@endsection