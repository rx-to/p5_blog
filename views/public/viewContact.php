<div class="container">
    <section>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <p>Remplissez le formulaire ci-dessous et je vous répondrai au plus vite ! 😉</p>
                <form id="contactForm" class="ajax-form" method="post" action="/contact">
                <div class="ajax-form__alert" style="display: none;"></div>
                    <input type="hidden" name="action" value="sendContact">
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Nom</label>
                            <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Votre nom..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Prénom</label>
                            <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Votre prénom..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Votre adresse e-mail..." required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Objet</label>
                            <input class="form-control" id="subject" name="subject" type="text" placeholder="Sujet de votre demande de contact...">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Votre message..." required></textarea>
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