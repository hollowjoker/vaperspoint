@extends('layout.master')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-sm-12">
                <h1>List</h1>
                <hr class="border-secondary">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Book</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $each)
                            <tr>
                                <td>{{ $each->id }}</td>
                                <td>{{ $each->book_name }}</td>
                                <td>{{ $each->author }}</td>
                                <td>{{ $each->genre }}</td>
                                <td>{{ date('F d ,Y', strtotime($each->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop