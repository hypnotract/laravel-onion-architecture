## Table of Contents
- [Introduction](#introduction)
- [Modules](#modules)
    - [Auth Module](#auth-module)
    - [Blog Module](#blog-module)
- [Layers](#layers)
    - [Domain Layer](#domain-layer)
    - [Application Layer](#application-layer)
    - [Infrastructure Layer](#infrastructure-layer)
    - [Presentation Layer](#presentation-layer)
- [Rules](#rules)
- [Testing Strategy](#testing-strategy)
- [Folder Structure](#folder-structure)

## Introduction
This repository is an example of applying the Onion Architecture in a Laravel application.
The project is structured into modules, with a clear separation of concerns between different layers of the application.

## Microservices
Onion Architecture is well-suited for microservices when considering each microservice independently.
Every microservice possesses its own model and use cases, and specifies its own external interfaces for data retrieval or modification.
These interfaces can be implemented using adapters that connect to other microservices through HTTP REST.
This architecture is ideal for microservices, as the data access layer can include not just databases but also HTTP clients for communication with other microservices or external systems.
For simpler applications or when rapid development with straightforward data access is prioritized, traditional layered architecture may be more suitable due to its simplicity and ease of implementation.

## Modules
### Auth Module
The Auth module is located in the `modules/Auth` directory. It is decoupled from the Blog module and handles user authentication and authorization.
This module introduces multi-tenancy and the User domain model, which is used to represent a user in the system.
It binds the `User` model (implementation) to the `UserContract` (abstraction), giving the possibility to switch the implementation without affecting the rest of the application.
This module can be easily transformed into a package and reused in other projects, or converted into a microservice.

### Blog Module
The Blog module is located in the `src` directory. It is responsible for the core blog functionalities.
It introduces changes to the User domain model, adding a relationship with the Post domain model.
It **rebinds** a new `User` model (implementation) to the existing `UserContract` (abstraction) defined in the Auth Module.

## Layers
### Domain Layer
- Location: `Domain` namespace within each module.
- Description: The Domain layer is completely decoupled from other layers. It contains the business logic and domain models.
- Responsibilities:
  - Contain the core business logic and domain model.
  - Ensure consistency and integrity of the business domain.
### Application Layer
- Location: `Application` namespace within each module.
- Description: The Application layer is coupled with the Domain layer, and it contains the application logic.
- Responsibilities:
  - Manage application-specific logic and orchestrate operations.
  - Serve as a bridge between the presentation layer and the domain layer.
### Infrastructure Layer
- Location: `Infrastructure` namespace within each module.
- Description: The Infrastructure layer is coupled with the framework and contains details related to the database, the framework, and any external services used.
- Responsibilities:
  - Handle data persistence, such as database interactions and other technical details (external APIs, file systems, message queues, etc.).
  - Handle communication with external systems and services.
### Presentation Layer
- Location: `Presentation` namespace within the Blog module.
- Description: The Presentation layer handles incoming requests and returns responses to the client. It is the entry point of the domain from an external perspective.
- Responsibilities:
  - Handle HTTP requests and responses.
  - Manage user interactions and interfaces.

## Folder Structure
````
...
├── modules/
│   └── Auth/
│       ├── Application/
│       │   ├── Exceptions/
│       │   ├── Services/
│       │   └── ...
│       ├── Domain/
│       │   ├── Exceptions/
│       │   ├── Models/ (abstractions)
│       │   ├── Repositories/ (abstractions)
│       │   ├── Services/
│       │   ├── Validations/
│       │   └── ...
│       └── Infrastructure/
│           ├── Exceptions/
│           ├── Models/ (implementations)
│           ├── Providers/
│           ├── Repositories/ (implementations)
│           ├── Services/
│           └── ...
└── src/ (Blog)
│   ├── Application/
│   │   ├── Exceptions/
│   │   ├── Services/
│   │   └── ...
│   ├── Domain/
│   │   ├── Exceptions/
│   │   ├── Models/ (abstractions)
│   │   ├── Repositories/ (abstractions)
│   │   ├── Services/
│   │   ├── Validations/
│   │   └── ...
│   ├── Infrastructure/
│   │   ├── Exceptions/
│   │   ├── Models/ (implementations)
│   │   ├── Providers/
│   │   ├── Repositories/ (implementations)
│   │   ├── Services/
│   │   └── ...
│   └── Presentation/
│       ├── Commands/
│       └── Http/
...
````

## Rules
- Dependencies should always be from outer layers to inner layers.
- The Domain layer should not depend on any other layer.
- The Application layer should depend only on the Domain layer.
- Domain services (not required in smaller applications)
  - These are responsible for holding domain logic and business rules.
  - All the business logic should be implemented as a part of domain services.
  - Domain services are orchestrated by application services to serve business use-case.
  - They are NOT typically CRUD services and are usually standalone services.
- Application services
  - These are services responsible for just orchestrating steps for requests and should not have any business logic if Domain services are present.
  - The application services can be only called by Infrastructure services or Presentation layer.
- Internal communication within a single layer can occur and is sometimes necessary.
  - The Domain layer can contain multiple entities, value objects, domain services, and repositories that might need to interact with each other to enforce business rules.
  - The Application layer can contain multiple application services that might need to interact with each other to orchestrate operations.
- Create an interface in the inner layer whenever it requires functionality or services from an outer layer to ensure that the inner layer remains decoupled and independent of the specific implementations.

## Testing Strategy
Different layers of Onion Architecture have a different set of responsibilities and accordingly, there are different testing strategies.
Business rules that belong to the domain model, domain services and application services should be tested via Unit Testing.
As we move to the outer layers, it makes more sense to have integration tests in the infrastructure services and API tests in the presentation layer.
