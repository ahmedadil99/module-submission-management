@extends('layouts.dashboard')


@section('content')
<div class="agents">
    <div class="page-header">
    <div class="float-left">
    <h2>My Agents</h2>
    </div>
    <div class="float-right align-bottom">
    <h6 class="text-right align-bottom">Show all</h6>
    </div>
    <div class="clearfix"></div>
    </div>
    <hr />

    <div class="row">
        <div class="col-sm-3">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="/images/agent.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Carla</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary"><i class="icon-envelope"></i> <span class="badge badge-light">4</span></a>
                    <a href="#" class="btn btn-primary"><i class="icon-cog"></i></a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="/images/agent.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Carla</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary"><i class="icon-envelope"></i> <span class="badge badge-light">4</span></a>
                    <a href="#" class="btn btn-primary"><i class="icon-cog"></i></a>
                </div>
            </div>
        </div>
    </div>    
</div>
<br /><br /><br />
<div class="articles">
    <div class="page-header">
        <div class="float-left">
        <h2>Recent Articles</h2>
        </div>
        <div class="float-right align-bottom">
        <h6 class="text-right align-bottom">Show all</h6>
        </div>
        <div class="clearfix"></div>
    </div>
    <hr />

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Special title treatment</h3>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary"><i class="icon-edit"></i></a>
                    <a href="#" class="btn btn-primary"><i class="icon-eye-open"></i></a>
                    <a href="#" class="btn btn-primary"><i class="icon-share"></i></a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Special title treatment</h3>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary"><i class="icon-edit"></i></a>
                    <a href="#" class="btn btn-primary"><i class="icon-eye-open"></i></a>
                    <a href="#" class="btn btn-primary"><i class="icon-share"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection