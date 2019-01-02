const stripe = Stripe("pk_test_iGX1WWt4cmBmvG86JCZTknAy");
const elements = stripe.elements();
  var errors = $('#card-errors');
  // Custom styling can be passed to options when creating an Element.
  const style = {
    base: {
       color: '#32325d',
       lineHeight: '18px',
       fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
       fontSmoothing: 'antialiased',
       fontSize: '16px',
       '::placeholder': {
         color: '#aab7c4'
       }
     },
     invalid: {
       color: 'red',
       iconColor: 'red'
     }
  };
  const card = elements.create('card', {style});
  card.mount('#card-element');

  const form = $('form-stripe');
  const stripeTokenHandler = (token) => {
    // Insert the token ID into the form so it gets submitted to the server
    const hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.append(hiddenInput);
  }

  card.on('change', function(event) {
    if (event.error) {
      errors.text(event.error.message);
      form.addClass('has-error');
    } else {
      errors.text('');
      form.remove('has-error');
    }
  });

  $('#purchaseCredit').on('click', async () => {
    const {token, error} = await stripe.createToken(card);
    if (error) {
      const errorElement = $('card-errors');
      errors.text(error.message);
    } else {
      console.log('ici =>');
      var selectCurrent = $("#bannerOffer").children('a.hoverable-custom');
      var idOffer = selectCurrent.data('credit');
      console.log('offer  id =>', idOffer);
      console.log('TOKEN =>', token);
      stripeTokenHandler(token);
      let data = {
        idOffer: idOffer,
        tokenId: token
      };
      $.post(Routing.generate('api_apistripe_createcustomer'),data)
      .done(function(response) {
        console.log(response);
        displayToast(response, 'success');
      })
      .done(function(error) {
        displayCredit(reponse, 'error')
      });
    }
  });

  $('#bannerOffer').on('click', 'a', () => {
    var selectCurrent = $(this);
    console.log(selectCurrent);
    $('#bannerOffer').children('a.hoverable-custom').removeClass('hoverable-custom').addClass('hoverable');
    selectCurrent.addClass('hoverable-custom').removeClass('hoverable');
  });


  $(document).ready( () => {
    var banner = $('#bannerOffer').children('a').eq(1);
    banner.addClass("hoverable-custom");
  });
