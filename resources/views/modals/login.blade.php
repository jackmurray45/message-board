<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Login</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class = "input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-envelope prefix grey-text i-label"></i>
                            </span>
                            {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'E-mail Address', 'required', 'autocomplete'=> 'email']) !!}
                            
                        </div>
                        <br>
                        <div class = "input-group">
                            <span class="input-group-addon i-label">
                                <i class="fas fa-lock prefix grey-text i-label"></i>
                            </span>
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password' ,'required', 'autocomplete'=> 'current-password']) !!} 
                        </div>
                        <br>
                        <div class = "input-group" style = "left:20px;">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    {!! Form::submit('Login', ['class' => 'form-control btn btn-default']) !!}
                </div>
            </form>
        </div>
    </div>
</div>