# Revolux WordPress Theme - Product Requirements Document (PRD)

## 1. Executive Summary

### Product Name
Revolux - Professional WordPress Theme for Trade Industries

### Version
0.1.0 (Initial Development)

### Product Vision
Revolux is a modern, modular, and multifurpose WordPress theme specifically designed for trade professionals and service businesses. Built for ThemeForest marketplace, it aims to become the go-to solution for electricians, plumbers, HVAC technicians, glaziers, construction companies, handymen, welding shops, machine shops, and other trade-related businesses.

### Target Audience
1. **Technical Users**: Web developers and agencies purchasing the theme to customize for their clients
2. **Non-Technical End Users**: Trade business owners seeking a professional, ready-to-use website solution

### Key Success Metrics
- ThemeForest approval on first submission
- Achieve 500+ sales within first year
- Maintain 4.5+ star rating
- <2% refund rate
- Regular updates and feature additions

## 2. Market Analysis

### Competition Overview
- Current trade-specific themes on ThemeForest lack modern design and flexibility
- Most existing solutions are either too generic or too narrowly focused
- Opportunity for a comprehensive, industry-specific solution with modern technology stack

### Unique Value Proposition
- Industry-specific demo content and layouts for each trade
- Conversion-optimized templates (service pages, quote forms, appointment booking)
- Mobile-first responsive design
- Performance optimized for Core Web Vitals
- Comprehensive documentation and video tutorials
- Regular updates and dedicated support

## 3. Technical Architecture

### Core Technology Stack
- **WordPress**: 6.0+ compatibility
- **PHP**: 8.0+ (minimum required)
- **Page Builder**: Elementor (Free and Pro compatible)
- **Customizer Framework**: Kirki
- **Build Tools**: Webpack (pre-configured)
- **CSS Preprocessor**: SCSS
- **JavaScript**: ES6+ with Babel transpilation

### Theme Structure

```
revolux/
├── assets/
│   ├── css/           # Compiled CSS (webpack output)
│   ├── js/            # Compiled JS (webpack output)
│   ├── images/        # Theme images
│   └── fonts/         # Theme fonts
├── inc/
│   ├── classes/       # PHP Classes (namespaced)
│   │   ├── Theme.php          # Main singleton theme class (all frontend setup)
│   │   ├── Backend.php        # Admin/Customizer/Kirki integration
│   │   ├── Elementor.php      # Elementor integration and extensions
│   │   └── Autoloader.php     # Class autoloader
│   ├── helpers/       # Helper functions
│   ├── hooks/         # Custom action and filter hooks
│   └── template-tags/ # Template tag functions
├── template-parts/    # Reusable template parts
├── templates/         # Page templates
├── languages/         # Translation files
├── functions.php      # Theme bootstrap
├── style.css          # Theme header
└── [standard WP template files]
```

### Class Architecture Philosophy
The theme uses a streamlined three-class architecture:

1. **Theme Class (Singleton)**: Handles all frontend theme setup including:
	- Theme supports and features
	- Navigation menu registration
	- Widget area registration
	- Asset enqueueing (styles and scripts)
	- Image sizes
	- Content width
	- Theme text domain
	- All frontend-facing hooks and filters

2. **Backend Class**: Manages all admin and customizer functionality:
	- Kirki framework integration
	- Customizer panels, sections, and controls
	- Admin enhancements
	- Theme options management
	- Admin-specific scripts and styles

3. **Elementor Class**: Dedicated to page builder integration:
	- Custom widget registration (via companion plugin)
	- Custom controls and extensions
	- Elementor-specific styles and scripts
	- Template library integration

This consolidated approach provides clarity and maintainability while avoiding over-engineering for a ThemeForest product.

### Namespace Strategy
```php
namespace Revolux;           // Base namespace
namespace Revolux\Classes;   // Core classes
namespace Revolux\Helpers;   // Helper utilities
namespace Revolux\Elementor; // Elementor extensions
```

## 4. Feature Requirements

### Phase 1: Core Theme Foundation (v0.1.0)

#### 4.1 Theme Setup & Configuration
- **Autoloader Implementation**
	- PSR-4 compliant autoloading
	- Fallback for environments without Composer
	- Efficient class loading

- **Main Theme Class**
	- Theme setup and initialization
	- Constants definition
	- Hook registration
	- Dependency management

- **Asset Management**
	- Webpack-compiled CSS/JS enqueuing
	- Conditional loading based on page requirements
	- RTL support
	- Print styles

#### 4.2 Customizer Integration (Kirki)
- **Global Settings**
	- Site identity enhancements
	- Color schemes (industry-appropriate palettes)
	- Typography settings (Google Fonts integration)
	- Layout options (boxed/wide/full-width)

- **Header Options**
	- Multiple header layouts
	- Sticky header settings
	- Top bar configuration
	- Mobile menu options

- **Footer Options**
	- Widget area layouts
	- Copyright text
	- Social media links
	- Back-to-top button

- **Blog Settings**
	- Archive layouts (grid/list/masonry)
	- Single post options
	- Sidebar configurations

#### 4.3 Navigation & Menus
- Primary navigation menu
- Mobile navigation menu
- Footer menu
- Top bar menu (optional)
- Custom mega menu support (Phase 2)

#### 4.4 Widget Areas
- Header widget area
- Multiple footer widget areas (customizable columns)
- Sidebar widget areas
- Custom trade-specific widgets (Phase 2)

#### 4.5 Template System
- **Page Templates**
	- Full Width
	- Left Sidebar
	- Right Sidebar
	- Blank Canvas (for page builders)
	- Landing Page

- **Post Types Support**
	- Services (custom post type - via companion plugin)
	- Projects/Portfolio (custom post type - via companion plugin)
	- Team Members (custom post type - via companion plugin)
	- Testimonials (custom post type - via companion plugin)

### Phase 2: Companion Plugin (revolux-core)

#### 4.6 Custom Post Types
- Services with categories
- Projects/Portfolio with filtering
- Team Members with roles
- Testimonials with ratings
- Locations (for multi-location businesses)

#### 4.7 Elementor Widgets
- Service Grid/List
- Project Gallery
- Team Carousel
- Testimonial Slider
- Pricing Tables
- Appointment Booking
- Quote Request Form
- Business Hours
- Emergency Contact CTA

#### 4.8 Industry-Specific Features
- Service area maps
- License/certification display
- Insurance/bonding badges
- Emergency service banners
- Before/after galleries
- Cost calculators

### Phase 3: Demo Content & Import

#### 4.9 Demo Variations
1. **Electrician Demo**
	- Residential/Commercial services
	- Emergency electrical services
	- Electrical safety tips blog

2. **Plumbing Demo**
	- Service listings
	- Drain cleaning focus
	- Water damage prevention content

3. **HVAC Demo**
	- Heating/cooling services
	- Maintenance plans
	- Energy efficiency focus

4. **Construction Demo**
	- Project portfolio heavy
	- Service categories
	- Safety compliance

5. **Handyman Demo**
	- Multi-service layout
	- Task-based pricing
	- Home maintenance tips

6. **General Trades Demo**
	- Flexible layout
	- Multiple service areas
	- Customizable sections

## 5. Development Standards

### 5.1 Coding Standards

#### PHP Standards
- WordPress Coding Standards (with exceptions)
- **PHP 8.0+ minimum requirement**
- **Strict typing: All functions/methods MUST have type declarations and return types**
- Short array syntax `[]` preferred
- Snake_case for all variables
- Comprehensive docblocks for all functions/methods
- Use of PHP 8.0+ features encouraged (null safe operator, match expressions, etc.)

#### Type Declaration Examples
```php
<?php
declare(strict_types=1);

namespace Revolux;

class Theme {
    /**
     * Initialize theme setup.
     *
     * @since  0.1.0
     * @access public
     * @return void
     */
    public function init(): void {
        // Implementation
    }
    
    /**
     * Register navigation menus.
     *
     * @since  0.1.0
     * @access public
     * @param  array $menus Menu locations array.
     * @return bool         Success status.
     */
    public function register_menus(array $menus): bool {
        // Implementation
    }
}
```

#### Docblock Format
```php
/**
 * Brief description of the function/method.
 *
 * Extended description if necessary.
 *
 * @since  0.1.0
 * @access public|private|protected
 * @static (if applicable)
 * @param  type $variable Description
 * @return type Description
 * @global type $variable (if applicable)
 */
```

#### JavaScript Standards
- ES6+ syntax
- camelCase for variables and functions
- JSDoc comments for documentation

#### CSS/SCSS Standards
- BEM methodology for class naming
- kebab-case for classes and IDs
- Mobile-first approach
- CSS custom properties for theming

### 5.2 Performance Requirements
- Page load time < 3 seconds on standard hosting
- Google PageSpeed score > 90 (mobile and desktop)
- Lazy loading for images and videos
- Optimized database queries
- Minimal HTTP requests

### 5.3 Accessibility Standards
- WCAG 2.1 Level AA compliance
- Keyboard navigation support
- Screen reader compatibility
- Proper ARIA labels
- High contrast mode support

### 5.4 Security Standards
- Data sanitization and validation
- Nonce verification for forms
- SQL injection prevention
- XSS protection
- Regular security audits

## 6. Quality Assurance

### 6.1 Testing Requirements
- PHP 8.0, 8.1, 8.2, 8.3 compatibility
- WordPress 6.0+ testing
- Cross-browser testing (Chrome, Firefox, Safari, Edge)
- Mobile device testing (iOS and Android)
- Plugin compatibility testing
- Theme check plugin compliance
- PHPStan level 6+ compliance for type safety

### 6.2 Documentation Requirements
- Installation guide
- Quick start guide
- Customization documentation
- Video tutorials
- Developer documentation
- Changelog maintenance

### 6.3 Support Structure
- ThemeForest comments support
- Knowledge base articles
- FAQ section
- Video tutorials
- Update notifications

## 7. Development Phases Timeline

### Phase 1: Core Development (Weeks 1-4)
- Week 1: Theme foundation and class structure
- Week 2: Kirki integration and customizer options
- Week 3: Template system and responsive layouts
- Week 4: Testing and refinement

### Phase 2: Companion Plugin (Weeks 5-8)
- Week 5-6: Custom post types and taxonomies
- Week 7: Elementor widgets development
- Week 8: Integration testing

### Phase 3: Demo Content (Weeks 9-10)
- Week 9: Demo creation and import functionality
- Week 10: Documentation and final testing

### Phase 4: Launch Preparation (Weeks 11-12)
- Week 11: ThemeForest submission preparation
- Week 12: Marketing materials and launch

## 8. Success Criteria

### Minimum Viable Product (MVP)
- Fully functional WordPress theme
- 3+ complete demo imports
- Elementor page builder compatibility
- Comprehensive customizer options
- Mobile responsive design
- Basic documentation

### Success Metrics
- ThemeForest approval without soft rejection
- 50+ sales in first month
- <5% support ticket rate
- 4.5+ star average rating

## 9. Risk Management

### Technical Risks
- **Elementor API changes**: Maintain compatibility layer
- **WordPress updates**: Regular testing and updates
- **Performance issues**: Continuous optimization

### Market Risks
- **Competition**: Regular feature updates and improvements
- **Market saturation**: Unique features and superior support

### Mitigation Strategies
- Regular updates and maintenance
- Active community engagement
- Continuous market research
- Feature roadmap based on user feedback

## 10. Post-Launch Roadmap

### Version 1.1 (Month 2-3)
- WooCommerce integration
- Booking system enhancement
- Additional Elementor widgets
- Performance optimizations

### Version 1.2 (Month 4-5)
- Multi-language support (WPML/Polylang)
- Advanced portfolio features
- Email marketing integrations
- White label options

### Version 2.0 (Month 6+)
- Gutenberg blocks support
- AI-powered content generation
- Advanced analytics dashboard
- SaaS model for agencies

## 11. Implementation Guidelines for AI Assistants

### Class Structure Guidelines
The theme uses a **consolidated three-class architecture**:
1. **Theme Class** (Singleton) - All frontend setup in one place
2. **Backend Class** - All admin/customizer functionality
3. **Elementor Class** - All page builder integration

Do NOT create separate classes for assets, menus, widgets, etc. Keep functionality consolidated within these three main classes for simplicity and maintainability.

### PHP 8.0+ Requirements
1. **Always use `declare(strict_types=1);` at the top of PHP files**
2. **Every function/method MUST have:**
	- Parameter type declarations
	- Return type declarations
	- Proper null safety considerations
3. **Leverage PHP 8.0+ features:**
	- Null safe operator (`?->`)
	- Match expressions where appropriate
	- Constructor property promotion
	- Named arguments for clarity

### Type Declaration Examples
```php
// Good - with proper types
public function enqueue_styles(string $handle, string $src, array $deps = []): void

// Bad - missing types
public function enqueue_styles($handle, $src, $deps = [])
```

### When Building Components
1. Always follow the established namespace structure
2. Include comprehensive docblocks as specified
3. Use strict typing for all parameters and returns
4. Consolidate related functionality within the three main classes
5. Implement hooks for extensibility
6. Follow WordPress best practices
7. Ensure code is testable and maintainable

### Priority Order for Development
1. Core theme class (singleton pattern) with all frontend setup
2. Backend class with Kirki integration
3. Elementor integration class (if needed)
4. Helper functions and template tags
5. Performance optimizations

### Code Review Checklist
- [ ] Uses PHP 8.0+ with strict types declared
- [ ] All functions have parameter and return type declarations
- [ ] Follows WordPress coding standards (with noted exceptions)
- [ ] Proper sanitization and escaping
- [ ] Comprehensive docblocks
- [ ] No hardcoded strings (i18n ready)
- [ ] Efficient database queries
- [ ] Proper hook usage
- [ ] Mobile responsive
- [ ] Accessibility compliant
- [ ] Consolidated within appropriate main class

## 12. Conclusion

Revolux represents a significant opportunity in the WordPress theme market for trade industries. By focusing on industry-specific needs, modern development practices, and user experience, we aim to create a product that not only meets market demands but exceeds expectations.

The modular architecture and clear separation of concerns between the theme and companion plugin ensure maintainability, updatability, and extensibility. This PRD serves as the foundation for all development decisions and should be referenced throughout the development process.

---

**Document Version**: 1.0.0  
**Last Updated**: November 2024  
**Status**: Active Development  
**Contact**: Development Team Lead
