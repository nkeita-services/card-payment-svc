#### Build container image locally
```
docker build . -t card-payment-svc
```

#### Run container image locally
```
docker run PORT=80 -d -p 8082:80 card-payment-svc:latest
```

#### Build container image using Cloud Build
```
gcloud builds submit --tag gcr.io/wallet-254709/card-payment-svc:0.0.1
```

#### Build container image using Cloud Build
```
gcloud beta run deploy --image gcr.io/wallet-254709/card-payment-svc:0.0.1 --platform managed
```

#### Test Stripe Webhook
```
stripe login
stripe listen --forward-to http://localhost:8099/v1/stripe/payments/intents/webhook
stripe trigger payment_intent.created
```

#### Test Stripe Pay In Form
[Stripe Payment Form](http://localhost:8099/v1/stripe/payments/form/1000/EUR/5e6e9889f5aae9439c41757b/5e6bf1567127a743ad93e3b2)
[Credit Cards](https://stripe.com/docs/payments/accept-a-payment)
