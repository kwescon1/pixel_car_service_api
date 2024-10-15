# Define a symbol for recursively expanding variables (used for better performance)
.ONESHELL:

# Color variables
YELLOW  = \033[33m
RESET   = \033[0m

# Define the default target
help: ## Print help
	@printf "\nUsage:\n  make \033[36m<target>\033[0m\n"
	@printf "Targets:\n"
	@awk 'BEGIN {FS = ":.*##"; printf ""} \
	/^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

# API commands
setup: ## Build the Docker container for the car_service_api without using cache
	@printf "$(YELLOW)Building the car_service_api Docker container...$(RESET)\n"
	@docker-compose build --no-cache

up: ## Start the car_service_api Docker containers in detached mode
	@printf "$(YELLOW)Starting the car_service_api Docker containers...$(RESET)\n"
	@docker-compose up -d

down: ## Stop and remove the car_service_api Docker container
	@printf "$(YELLOW)Stopping the car_service_api Docker container...$(RESET)\n"
	@docker-compose down

logs-api: ## Show real-time logs from the car_service_api Docker container
	@printf "$(YELLOW)Showing logs from the car_service_api Docker container...$(RESET)\n"
	@docker-compose logs -f

shell: ## Access the shell of the API container
	@printf "$(YELLOW)Entering API shell...$(RESET)\n"
	@docker exec -it -u ubuntu carservice /bin/bash
