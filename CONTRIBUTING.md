# Contributing to DreamPay

Thank you for considering contributing to DreamPay! This document outlines the process for contributing to this project.

## Code of Conduct

- Be respectful and professional
- Focus on constructive criticism
- Help others learn and grow

## How to Contribute

### Reporting Bugs

1. Check if the bug has already been reported in Issues
2. If not, create a new issue with:
   - Clear title and description
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details (PHP version, OS, etc.)

### Suggesting Features

1. Open an issue with the `enhancement` label
2. Clearly describe the feature and its use case
3. Explain why this feature would be useful

### Pull Requests

1. Fork the repository
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Make your changes
4. Write or update tests
5. Ensure all tests pass: `php artisan test`
6. Update documentation if needed
7. Commit with clear messages
8. Push to your fork
9. Create a Pull Request

## Development Guidelines

### Code Style

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

### Testing

- Write tests for new features
- Ensure existing tests pass
- Aim for high code coverage
- Test edge cases and error conditions

### Security

- Never commit sensitive data (.env files, keys, passwords)
- Follow OWASP security guidelines
- Report security vulnerabilities privately to security@dreampay.id

### Commit Messages

Format:
```
type(scope): subject

body (optional)

footer (optional)
```

Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

Example:
```
feat(auth): add PIN verification for transfers

Implemented Hash::check for secure PIN verification
Added rate limiting to prevent brute force attacks

Closes #123
```

## Development Setup

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env`
4. Generate app key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Run tests: `php artisan test`

## Questions?

Feel free to open an issue with the `question` label.

---

Thank you for contributing to DreamPay! 🚀
