<div class="container">
    <section>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <form id="registerForm" class="ajax-form" method="post" action="">
                    <input type="hidden" name="action" value="register">
                    <div class="control-group">
                        <div class="ajax-form__alert" style="display: none;"></div>
                        <div class="form-group floating-label-form-group controls">
                            <label for="last_name">Nom</label>
                            <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Votre nom..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label for="first_name">Prénom</label>
                            <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Votre prénom..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label for="email">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Votre adresse e-mail..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="password">Mot de passe</label>
                            <input class="form-control" id="password" name="password" type="password" placeholder="Votre mot de passe..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label for="birthdate">Date de naissance</label>
                            <input class="form-control" id="birthdate" name="birthdate" type="date" placeholder="Votre date de naissance..." required>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary mt-0" id="sendMessageButton" type="submit">S'inscrire</button>
                </form>
                <p class="mb-0">Vous avez déjà un compte ? <a href="/connexion/">Connectez-vous</a>.</p>
            </div>
        </div>
    </section>
</div>
