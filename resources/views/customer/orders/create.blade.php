@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Order</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create Order</button>
    </form>
</div>
@endsection 