<div class="row justify-content-center">
    <div class="col-md-6 text-white">
        <h1 class="mt-5">Create an account</h1>
        <form action="/auth/register" method="POST" class="form">
            <div class="form-group">
                <label for="email_field">Email</label>
                <input type="email" id="email_field" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="login_field">Login</label>
                <input type="text" id="login_field" class="form-control" name="login" required>
            </div>
            <div class="form-group">
                <label for="name_field">Name</label>
                <input type="text" id="name_field" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname_field">Surname</label>
                <input type="text" id="surname_field" class="form-control" name="surname" required>
            </div>
            <div class="form-group">
                <label for="password_field">Password</label>
                <input type="password" id="password_field" class="form-control" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<div>