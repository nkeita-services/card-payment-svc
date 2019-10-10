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
