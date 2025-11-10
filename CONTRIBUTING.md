# Contributing to Dashboard Store

Thank you for considering contributing to Dashboard Store! We welcome contributions from the community.

## Code of Conduct

Please be respectful and constructive in all interactions with other contributors.

## How to Contribute

### Reporting Bugs

1. Check if the bug has already been reported in the [Issues](https://github.com/zakeyhizem/Dashbord-Store/issues)
2. If not, create a new issue with:
   - Clear title and description
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details (PHP version, Laravel version, etc.)

### Suggesting Features

1. Check if the feature has already been suggested
2. Create a new issue with:
   - Clear description of the feature
   - Use cases and benefits
   - Possible implementation approach

### Pull Requests

1. Fork the repository
2. Create a new branch for your feature/fix:
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. Make your changes following our coding standards:
   - Follow PSR-12 coding standards
   - Write meaningful commit messages
   - Add tests for new features
   - Update documentation as needed

4. Test your changes:
   ```bash
   composer test
   ```

5. Commit your changes:
   ```bash
   git commit -m "Add feature: description"
   ```

6. Push to your fork:
   ```bash
   git push origin feature/your-feature-name
   ```

7. Create a Pull Request with:
   - Clear description of changes
   - Reference to related issues
   - Screenshots (if applicable)

## Development Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/zakeyhizem/Dashbord-Store.git
   cd Dashbord-Store
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Run tests:
   ```bash
   composer test
   ```

## Coding Standards

- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Write clear comments for complex logic
- Keep methods small and focused
- Use type hints where applicable
- Write tests for new functionality

## Testing

- Write unit tests for business logic
- Write feature tests for API endpoints
- Ensure all tests pass before submitting PR
- Aim for high test coverage

## Documentation

- Update README.md if adding new features
- Update API.md for new endpoints
- Add inline documentation for complex code
- Update ARCHITECTURE.md for structural changes

## Module Development

When creating new modules:

1. Create module directory: `app/Modules/YourModule/`
2. Create module class extending base module
3. Add module configuration
4. Write tests for module functionality
5. Update documentation

## Payment Gateway Integration

When adding new payment gateways:

1. Create service class in `app/Services/`
2. Implement required methods
3. Add configuration in `config/payment.php`
4. Update controllers to support new gateway
5. Add tests for payment processing
6. Update documentation

## Questions?

Feel free to ask questions by creating an issue or reaching out to the maintainers.

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
