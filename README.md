#### Build container image using Cloud Build
```
gcloud builds submit --tag gcr.io/wallet-254709/card-payment-svc:0.0.1
```

#### Build container image using Cloud Build
```
gcloud beta run deploy --image gcr.io/wallet-254709/card-payment-svc:0.0.1 --platform managed
```
