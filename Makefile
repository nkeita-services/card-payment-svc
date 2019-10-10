build: ##@Intsall Dependencies
	composer install
up: build ##@Run locally
	docker-compose up -d --build
deploy: ##@Build and deploy to Cloud Run
	gcloud builds submit --tag gcr.io/wallet-254709/card-payment-svc
	gcloud beta run deploy --image gcr.io/wallet-254709/card-payment-svc --platform managed
