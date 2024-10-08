<!DOCTYPE html>
<html lang="en">
<head>
    @include('backend::elements.head')
</head>
<body>
    <div
        class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20"
    >
        <div class="pd-10">
            <div class="error-page-wrap text-center">
                <h1>404</h1>
                <h3>Error: 404 Page Not Found</h3>
                <p>
                    Sorry, the page you’re looking for cannot be accessed.<br />Either
                    check the URL
                </p>
                <div class="pt-20 mx-auto max-width-200">
                    <a href="{{route('admin-dashboard')}}" class="btn btn-primary btn-block btn-lg"
                        >Back To Home</a
                    >
                </div>
            </div>
        </div>
    </div>
    @include('backend::elements.footer')
</body>