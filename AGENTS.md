# AGENTS.md

## Project Purpose
This repository is a **production-grade architecture prototype** designed to demonstrate senior-level system design, engineering practices, and DevOps maturity for a Symfony-based full‑stack e‑commerce platform.

The objective is not feature completeness, but **engineering quality**, **architecture clarity**, and **process excellence**:
- Domain‑driven design
- Clean architecture
- Test‑first development
- CI/CD‑first development
- Infrastructure as code
- Architectural variants
- Trade‑off documentation
- Production‑grade standards

This project is intentionally designed as an **architecture showcase** and **system design artifact** for technical interviews and senior engineering evaluation.

---

## Core Principles

1. CI/CD is created before features  
2. Tests are written before business logic  
3. Architecture precedes implementation  
4. Domain logic is isolated from frameworks  
5. Infrastructure is code, not configuration  
6. Variants are branches, not forks  
7. Rebase is used for architectural inheritance  
8. Merge is used for stabilization  
9. Monorepo governance, multi‑image runtime  
10. Quality gates are mandatory, not optional  
11. **SEO is critically important** — no shortcuts on search optimization
12. **No shortcuts** — production-grade quality from day one  
13. **Never proceed after any push until CI passes** — CI is the backbone of this project

---

## CI/CD Monitoring

### Trigger Rules
- **CI**: Push to `main`, `develop`, or branches matching `arch-*` triggers CI
- **CI**: Pull requests to `main` or `develop` trigger CI
- **CD**: Push to `main` or tags matching `v*` triggers CD

### Monitoring Commands
```bash
# Check CI status for current branch
gh run list --repo cesarbahena/quimi-commerce --branch arch-ssg --limit 5

# Check CD status
gh run list --repo cesarbahena/quimi-commerce --workflow=cd --limit 5

# Check latest run details
gh run view <run-id> --repo cesarbahena/quimi-commerce

# Rerun failed jobs
gh run rerun <run-id> --failed --repo cesarbahena/quimi-commerce
```

### Monitoring URLs
- **GitHub Actions**: https://github.com/cesarbahena/quimi-commerce/actions

### Local CI Testing (Required Before Push)
Run these commands locally before every push to replicate CI environment:

```bash
# Lint
cd backend && composer install --prefer-dist --no-interaction
vendor/bin/php-cs-fixer fix --dry-run --diff

# Static Analysis
vendor/bin/phpstan analyse --level=6 --no-progress
vendor/bin/psalm

# Security
composer audit --abandoned=ignore

# Unit Tests (no coverage - requires xdebug/pcov)
vendor/bin/phpunit --testsuite=unit --no-coverage

# Integration Tests (requires postgres + redis)
vendor/bin/phpunit --testsuite=integration --no-coverage
```

**Required tools for local testing:**
- PHP 8.3+ with extensions: mbstring, pdo_pgsql, bcmath
- Composer
- PostgreSQL (for integration tests)
- Redis (for integration tests)

### Local Docker Build Testing (Recommended Before CD Push)
Test Docker builds locally before pushing to main:

```bash
# Build backend
docker build -t backend:test -f backend/Dockerfile backend/

# Build frontend
docker build -t frontend:test -f frontend/twig/Dockerfile frontend/twig/
```

### CD Requirements
- **Lock files must be tracked**: `composer.lock` and `package-lock.json` must be in git
- **No cache on first run**: First CD run will be slow; subsequent runs use cache
- **Images pushed to**: `ghcr.io/cesarbahena/quimi-commerce/backend` and `ghcr.io/cesarbahena/quimi-commerce/frontend-twig`  

---

## Repository Model

### Monorepo Governance
Single repository with multiple independent runtime images.

### Runtime Isolation
Each component is an independent container image:
- Symfony API
- Symfony workers
- Symfony SSG frontend
- Next.js SSR frontend
- Reverse proxy (nginx)

Monorepo = governance and CI/CD  
Containers = runtime isolation and scalability  

---

## Architecture Variants

### Rendering Variants
- **SSG**: Symfony backend + Symfony Twig frontend (static export)
- **SSR**: Symfony backend + Next.js frontend (server-side rendering)

### Infrastructure Variants
- Docker Compose (development)
- Kubernetes (production)

Resulting valid system configurations:
1. Symfony SSG + Docker Compose
2. Symfony SSG + Kubernetes
3. Symfony API + Next.js SSR + Docker Compose
4. Symfony API + Next.js SSR + Kubernetes

---

## Branch Strategy

Branches represent **architectural decisions**, not features.

### Core Branches
- `main` → canonical architecture (SSG feature-complete)
- `develop` → integration branch

### Variant Branches
- `arch-ssg` → Symfony + Twig SSG (feature-complete → merge to main)
- `arch-ssr` → Next.js SSR frontend (migrates from Twig)
- `auth-jwt` → JWT authentication (rebased into SSR)
- `infra-k8s` → Kubernetes deployment (branch from main)

### Flow
1. `arch-ssg` → develop → `main` (SSG feature-complete)
2. `main` → `arch-ssr` (create SSR branch from main)
3. `auth-jwt` → rebase into `arch-ssr` (JWT auth)
4. `arch-ssr` → `main` (SSR merge)
5. `main` → `infra-k8s` (Kubernetes variant)

### Rules
- **Rebase** → architectural inheritance
- **Merge** → stabilization
- No long‑living feature branches
- No duplicated implementations
- No forked logic

---

## Development Order

### Phase 1 — CI/CD First
- GitHub Actions pipelines
- Linting
- Static analysis
- Test runners
- Build pipelines
- Security scans

No feature development before CI exists.

---

### Phase 2 — Test First
Hybrid TDD strategy:

| Layer | Strategy |
|------|--------|
| Domain | TDD |
| Validation | TDD |
| Value Objects | TDD |
| Services | TDD |
| External Adapters | TDD |
| Controllers | Test-after |
| UI | Test-after |
| Infra | Test-after |

---

### Phase 3 — Backend Core
- Symfony skeleton
- Clean Architecture layering
- Domain model
- Validation model
- Error model
- External API abstraction
- Async processing
- Logging
- Health checks

---

### Phase 4 — SSG Variant
- Twig frontend
- SSR controllers
- Static export pipeline
- Sitemap generation
- Cache warming
- CDN-ready output
- **Feature-complete before merging to main**

---

### Phase 5 — Auth Variant
- JWT authentication
- Refresh tokens
- Token rotation
- Stateless security model
- Sessions migrated to JWT for SSR compatibility

---

### Phase 6 — SSR Variant
- Next.js frontend
- API integration
- Server-side rendering
- Frontend decoupling

JWT branch is rebased into SSR branch.

---

### Phase 7 — Infrastructure
- Docker Compose environment
- Kubernetes manifests (branch from main)
- Helm charts
- Deployment automation

---

## CI/CD Policy

### CI Pipelines
- Lint
- Static analysis
- Unit tests
- Integration tests
- Coverage
- Build
- Security scanning
- Image scanning

### CD Pipelines
- Multi‑image build
- Registry push
- Environment deploy
- Rollout validation

### Path‑based builds
- backend/** → backend image
- frontend/twig/** → SSG image
- frontend/nextjs/** → SSR image
- infra/** → deployment pipelines

---

## Docker Image Standards

### General Rules
- Multi‑stage builds only
- No build tools in runtime images
- Non‑root users
- Minimal base images
- Deterministic builds
- Immutable tags
- No secrets in images
- Config via env only
- Health checks mandatory
- Graceful shutdown support

### Security
- Image scanning
- Dependency scanning
- SBOM generation
- Minimal attack surface
- Least‑privilege execution

---

## Testing Strategy

### Backend
- Unit tests (Domain)
- Integration tests (API)
- Contract tests (External APIs)
- Async flow tests
- DB transaction isolation

### Frontend
- Unit tests
- Integration tests
- E2E tests

### Quality Gates
- Coverage thresholds
- Static analysis levels
- Lint enforcement
- Architecture rule enforcement

---

## Validation Architecture

- Frontend structural validation
- Backend domain validation
- Value objects
- External API validation
- Error abstraction
- User‑friendly error mapping
- Async verification flows

---

## Observability

- Structured logging
- Correlation IDs
- Metrics endpoint
- Health endpoints
- Error tracking integration
- Audit logs
- RFC validation logs

---

## Documentation Rules

All architecture decisions must be documented in `/docs`:
- System design
- Trade‑offs
- Variant comparisons
- Security model
- CI/CD model
- Infra model
- Testing model

---

## Commit Conventions

Conventional commits:

- feat:
- fix:
- test:
- ci:
- chore:
- docs:
- refactor:

Architecture‑level commits only.

---

## Engineering Philosophy

This project is built to demonstrate:

- Architectural thinking
- Production realism
- System design maturity
- Engineering governance
- Quality‑first development
- Process discipline
- DevOps integration
- Operational thinking

This is not a demo app.  
This is a **system design artifact**.

