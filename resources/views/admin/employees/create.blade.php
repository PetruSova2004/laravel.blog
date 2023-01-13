@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Создание работника</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Создание работника</h3>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('employees.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name"
                                           class="form-control @error('title') is-invalid @enderror" id="name"
                                           placeholder="Имя">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email"
                                           class="form-control @error('title') is-invalid @enderror" id="email"
                                           placeholder="Email">
                                </div>
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
