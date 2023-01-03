<html>
<head>
    <title>{{$bs->website_title}}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/503.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
</head>
<body>
<!--    Error section start   -->

<div class="container ptb-90">
    <div class="row align-items-center g">
        <div class="col-md-12 mx-auto text-center">
            <div class="payment-img mb-50">
                <img class="w-50" src="{{asset('assets/front/img/404.svg')}}" alt="Success Illustration" >
            </div>
        </div>
    </div>
    <div class="row align-items-center ">
        <div class="col-md-12 mx-auto text-center" id="mt">
            <div class="payment mb-30">
                <div class="payment_header">
                    <div class="check color-primary">
                        <i class="fa fa-exclamation-circle text-warning"></i>
                    </div>
                </div>
                <div class="content">


                    <h2 class="mb-4">{{__("You are lost")}}...</h2>
                    <p class="paragraph-text mb-4">
                    <p>{{__("The page you are looking for might have been moved, renamed, or might never existed.")}}</p>

                    <a href="{{route('front.index')}}" class="btn primary-btn">{{__('Go to Home')}}</a>


                </div>
            </div>
        </div>
    </div>
</div>
<!--    Error section end   -->
</body>
</html>




