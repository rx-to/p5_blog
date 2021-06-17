<div class="container">
    <section>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <p>Remplissez le formulaire ci-dessous et je vous répondrai au plus vite ! 😉</p>
                <form id="contactForm" name="sentMessage" novalidate>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Nom</label>
                            <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Votre nom..." required data-validation-required-message="Veuillez saisir votre nom.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Prénom</label>
                            <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Votre prénom..." required data-validation-required-message="Veuillez saisir votre prénom.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Votre adresse e-mail..." required data-validation-required-message="Veuillez saisir votre adresse e-mail.">
                        <p class=" help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>N° de téléphone</label>
                            <input class="form-control" id="phone_number" name="phone_number" type="tel" placeholder="Votre n° de téléphone..." required data-validation-required-message="Veuillez saisir votre numéro de téléphone...">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Objet</label>
                            <input class="form-control" id="subject" type="text" placeholder="Sujet de votre demande de contact...">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Votre message..." required data-validation-required-message="Veuillez saisir votre message."></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br />
                    <div id="success"></div>
                    <button class="btn btn-primary mt-0" id="sendMessageButton" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </section>
</div>