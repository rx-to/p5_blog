<div class="container">
    <section>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <form id="registerForm" class="ajax-form" method="post" action="">
                    <input type="hidden" name="action" value="login">
                    <div class="control-group">
                    <div class="ajax-form__alert" style="display: none;"></div>
                    <div class="form-group floating-label-form-group controls">
                            <label for="email">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Votre adresse e-mail..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label for="password">Mot de passe</label>
                            <input class="form-control" id="password" name="password" type="password" placeholder="Votre mot de passe..." required>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary mt-0" id="sendMessageButton" type="submit">Se connecter</button>
                </form>
                <p class="mb-0">Vous n'êtes pas encore inscrit ? <a href="/inscription/">Créez votre compte</a>.</p>
            </div>
        </div>
    </section>
</div>