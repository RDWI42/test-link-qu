<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>TEST LINK QU</title>
</head>
<style>
    .boxinsert {
        border-radius: 10px;
        box-shadow: 1px 1px 10px 1px;
        position: relative;
        width: 100%;
        height: 270px;
        background-color: white
    }

    body {
        background-color: #95afc0
    }

    .boxtable {
        border-radius: 10px;
        box-shadow: 1px 1px 10px 1px;
        position: relative;
        width: 100%;
        background-color: white
    }
</style>

<body>
    <div class="container" style="margin-top: 200px">
        <div class="col-md-6 offset-md-3 boxinsert">
            <div class="col-md-12" style="padding-top: 20px">
                <h4>INSERT DATA</h4>
            </div>
            <hr>
            <div class="col-md-12">
                @csrf
                <label for="data">INPUT DATA</label>
                <input type="text" class="form-control" id="data" name="data" placeholder="NAME[space]AGE[space]CITY">
                <div class="invalid-feedback" id="dataerror"></div>
            </div>
            <hr>
            <div class="col-md-12">
                <button class="btn btn-success" style="float: right" type="submit" id="submitdata">
                    SUBMIT <i class="bi bi-box-arrow-in-right"></i>
                </button>
            </div>
        </div>
        <br>
        <div class="row boxtable">
            <div class="col-md-12">
                <h4>DATA USER</h4>
                <hr>
            </div>
            <div class="table-responsive col-md-12">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Umur</th>
                            <th scope="col">Kota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $data->currentPage() > 1 ? ($data->perPage() *
                                ($data->currentPage() - 1) + $loop->iteration) : $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{$item->age}}</td>
                            <td>{{$item->city}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                Total Data : {{$data->total()}}
            </div>
            <div class="col-md-12 mt-2">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</body>

<script>
    var CSRF_TOKEN = $("meta[name='csrf-token']").attr("content");
    $(document).ready(function(){
        $('#submitdata').click(function(){
            let data = $('#data').val();
            if(data == null || data == ""){
                $('#data').addClass('is-invalid');
                $('#dataerror').html('Harap isi Data terlebih dahulu');
                $('#dataerror').css('display','block');
                $('#dataerror').delay(3200).fadeOut(300);
                setTimeout(function() {
                    $('#data').removeClass("is-invalid");
                }, 3200);
                return
            }else{
                let splitdata = data.split(" ")
                $.ajax({
                    url: `/AddData`,
                    type: "put",
                    cache: false,
                    data: {
                        "data": splitdata,
                        "_token": CSRF_TOKEN
                    },
                    success:function(response){
                        if(response.success == 1){
                            alert('Data Berhasil Di Tambahkan')
                            $('#data').val(null);
                        }else{
                            $('#data').addClass('is-invalid');
                            $('#dataerror').html(response.error);
                            $('#dataerror').css('display','block');
                            $('#dataerror').delay(3200).fadeOut(300);
                            setTimeout(function() {
                                $('#data').removeClass("is-invalid");
                            }, 3200);
                        }
                    },
                    error:function(error){
                        console.log("error : " + JSON.stringify(error) );
                    }

                });
            }
        })
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script>

</html>