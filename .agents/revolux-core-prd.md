# Revolux Core Plugin - Product Requirements Document (PRD)

## 1. Executive Summary

### Product Name
Revolux Core - Companion Plugin for Revolux WordPress Theme

### Version
0.1.0 (Initial Development)

### Product Vision
Revolux Core is a companion plugin that extends the Revolux theme with advanced functionality, custom post types, Elementor widgets, and trade-specific features. It maintains separation of concerns by handling all non-presentation logic, ensuring theme switching doesn't break content while providing powerful tools for trade businesses.

### Relationship to Theme
- **Theme (Revolux)**: Handles presentation, layouts, styling, and basic WordPress features
- **Plugin (Revolux Core)**: Manages custom functionality, post types, widgets, and business logic
- **Dependency**: Plugin requires Revolux theme for optimal functionality but gracefully degrades

### Key Principles
- All custom post types and taxonomies in plugin (preserves content on theme switch)
- Trade-specific functionality isolated in plugin
- Elementor widgets and extensions in plugin
- Theme handles only presentation layer
- Clean separation of concerns

## 2. Technical Architecture

### Core Technology Stack
- **PHP**: 8.0+ (minimum required, matching theme)
- **WordPress**: 6.0+ compatibility
- **Elementor**: 3.5+ (Free version minimum, Pro compatible)
- **Dependencies**: Revolux Theme (soft dependency with fallbacks)
- **Build Tools**: Webpack for widget assets
- **Type Safety**: Strict typing throughout

### Plugin Structure

```
revolux-core/
├── assets/
│   ├── css/               # Widget and feature styles
│   ├── js/                # Widget scripts and admin JS
│   └── images/            # Plugin images/icons
├── inc/
│   ├── classes/           # Core plugin classes
│   │   ├── Plugin.php             # Main plugin singleton class
│   │   ├── PostTypes.php          # Custom post type registration
│   │   ├── Taxonomies.php         # Custom taxonomy registration
│   │   ├── Metaboxes.php          # Custom metaboxes (CMB2 or custom)
│   │   ├── Shortcodes.php         # Shortcode management
│   │   ├── Ajax.php               # AJAX handlers
│   │   ├── API.php                # External API integrations
│   │   └── Autoloader.php         # Class autoloader
│   ├── elementor/         # Elementor integration
│   │   ├── Manager.php            # Widget registration manager
│   │   ├── widgets/               # Individual widget classes
│   │   ├── controls/              # Custom controls
│   │   └── dynamic-tags/          # Dynamic tag extensions
│   ├── post-types/        # Post type specific functionality
│   │   ├── Services.php           # Services CPT logic
│   │   ├── Projects.php           # Projects CPT logic
│   │   ├── Team.php               # Team CPT logic
│   │   └── Testimonials.php       # Testimonials CPT logic
│   ├── trade-features/    # Trade-specific modules
│   │   ├── Electrician.php        # Electrical trade features
│   │   ├── Plumbing.php           # Plumbing trade features
│   │   ├── HVAC.php               # HVAC trade features
│   │   ├── Construction.php       # Construction features
│   │   └── TradeBase.php          # Base class for trade features
│   ├── helpers/           # Helper functions
│   └── admin/             # Admin-specific functionality
│       ├── Dashboard.php           # Plugin dashboard
│       ├── Settings.php            # Plugin settings page
│       └── ImportExport.php        # Demo import/export
├── templates/             # Template files for CPTs
│   ├── single-service.php
│   ├── archive-services.php
│   ├── single-project.php
│   └── [other templates]
├── languages/             # Translation files
├── revolux-core.php       # Main plugin file
└── uninstall.php          # Cleanup on uninstall
```

### Namespace Strategy
```php
namespace RevoluxCore;                    // Base namespace
namespace RevoluxCore\Classes;            // Core classes
namespace RevoluxCore\Elementor;          // Elementor components
namespace RevoluxCore\Elementor\Widgets;  // Widget classes
namespace RevoluxCore\PostTypes;          // CPT handlers
namespace RevoluxCore\TradeFeatures;      // Trade-specific features
namespace RevoluxCore\Admin;              // Admin functionality
```

### Class Architecture
Following the theme's consolidated approach:

1. **Plugin Class** (Singleton) - Main orchestrator
	- Plugin initialization
	- Dependency checking
	- Hook registration
	- Asset loading
	- License management (if premium)

2. **PostTypes Class** - All CPT registration
	- Services
	- Projects/Portfolio
	- Team Members
	- Testimonials
	- Locations

3. **Taxonomies Class** - All taxonomy registration
	- Service Categories
	- Project Types
	- Skills/Expertise
	- Service Areas

4. **Elementor Manager Class** - Widget orchestration
	- Widget registration
	- Category creation
	- Asset enqueueing
	- Dynamic tags

## 3. Feature Requirements

### 3.1 Custom Post Types

#### Services CPT
```php
Post Type: 'revolux_service'
```
**Fields:**
- Service title
- Service description (editor)
- Service icon/image
- Price range/starting price
- Duration estimate
- Service gallery
- Features list (repeatable)
- Call-to-action button
- Emergency service flag
- Availability status

**Taxonomies:**
- Service Categories (hierarchical)
- Service Tags (non-hierarchical)
- Service Areas (hierarchical)

#### Projects/Portfolio CPT
```php
Post Type: 'revolux_project'
```
**Fields:**
- Project title
- Project description
- Before/after gallery
- Project cost range
- Completion date
- Duration
- Client testimonial
- Materials used
- Team members involved
- Location/address

**Taxonomies:**
- Project Types (hierarchical)
- Project Tags (non-hierarchical)
- Industries Served (hierarchical)

#### Team Members CPT
```php
Post Type: 'revolux_team'
```
**Fields:**
- Name
- Position/role
- Bio (editor)
- Photo
- Qualifications/certifications (repeatable)
- Years of experience
- Specializations
- Social media links
- Contact information
- License numbers

**Taxonomies:**
- Departments (hierarchical)
- Expertise Areas (non-hierarchical)

#### Testimonials CPT
```php
Post Type: 'revolux_testimonial'
```
**Fields:**
- Client name
- Client company (optional)
- Client photo (optional)
- Testimonial text
- Rating (1-5 stars)
- Service received
- Project link (optional)
- Date
- Featured flag
- Video testimonial URL

**Taxonomies:**
- Testimonial Categories (hierarchical)

#### Locations CPT (Multi-location businesses)
```php
Post Type: 'revolux_location'
```
**Fields:**
- Location name
- Address fields
- Phone numbers
- Email
- Hours of operation (complex field)
- Service area map
- Team members assigned
- Services offered
- Location manager
- Google Maps embed
- Location gallery

### 3.2 Elementor Widgets

#### Service Widgets

**Service Grid/Carousel**
- Layout options (grid/carousel/masonry)
- Columns control (1-6)
- Service selection (category/manual/featured)
- Card styles (5+ variations)
- Hover effects
- Quick inquiry modal
- Filterable by category
- Load more/pagination

**Service List**
- List layouts (simple/detailed/compact)
- Icon positions
- Expandable descriptions
- Pricing display options
- Booking integration

**Emergency Service Banner**
- 24/7 availability display
- Click-to-call functionality
- Animated attention grabbers
- Schedule exceptions
- Multiple style presets

#### Project/Portfolio Widgets

**Project Gallery**
- Gallery layouts (grid/masonry/slider)
- Before/after reveal styles
- Lightbox integration
- Filter by category
- Hover information
- Quick view modal

**Project Showcase**
- Featured project display
- Statistics/metrics display
- Timeline view
- Case study format

#### Team Widgets

**Team Grid/Carousel**
- Multiple card designs
- Social links integration
- Quick bio expand
- Department filtering
- Certification badges

**Team Member Profile**
- Single member showcase
- Full bio display
- Qualification timeline
- Contact form integration

#### Testimonial Widgets

**Testimonial Carousel**
- Multiple carousel styles
- Auto-rotation settings
- Rating display
- Video testimonial support
- Navigation styles

**Testimonial Grid**
- Masonry/grid layouts
- Filter by rating/service
- Load more functionality
- Featured testimonials

#### Business Information Widgets

**Business Hours**
- Regular hours display
- Holiday hours
- Emergency availability
- Multiple locations
- Current status (open/closed)
- Next opening time

**Contact Cards**
- Multiple card styles
- Click-to-call/email
- Map integration
- Form popup
- WhatsApp integration

**Location Map**
- Service area display
- Multiple locations
- Interactive markers
- Radius display
- Driving directions

#### Booking/Quote Widgets

**Quote Request Form**
- Multi-step forms
- Service selection
- File uploads
- Price estimation
- Conditional logic
- Email notifications
- CRM integrations

**Appointment Booking**
- Calendar integration
- Service selection
- Time slot availability
- Staff selection
- Confirmation emails
- Google Calendar sync
- Payment integration

**Price Calculator**
- Service-based calculations
- Area/quantity inputs
- Material selections
- Instant estimates
- Email quote option
- PDF generation

#### Call-to-Action Widgets

**CTA Boxes**
- Multiple styles
- Icon integration
- Animation effects
- Countdown timers
- Seasonal promotions

**Before/After Slider**
- Multiple slider styles
- Touch/drag support
- Vertical/horizontal
- Custom handles
- Labels/captions

#### Content Display Widgets

**Service Process/Steps**
- Timeline layouts
- Icon integration
- Animated reveals
- Progress indicators
- Expandable content

**Certifications Display**
- Logo grids
- Verification links
- Expiry tracking
- Authority badges

**FAQ Accordion**
- Category organization
- Search functionality
- Schema markup
- Multiple styles
- Expand/collapse all

### 3.3 Trade-Specific Features

#### Base Features (All Trades)
- License verification display
- Insurance/bonding badges
- Emergency service management
- Service area mapping
- Seasonal service promotions
- Maintenance reminders system
- Customer portal (basic)
- Invoice/estimate generation
- Review/reputation management

#### Electrician-Specific
```php
class Electrician extends TradeBase
```
- Electrical service categories (residential/commercial/industrial)
- Safety tip generator
- Electrical permit tracker
- Energy efficiency calculator
- Electrical emergency guide
- Code compliance badges
- Panel upgrade calculator
- Smart home integration showcase

#### Plumbing-Specific
```php
class Plumbing extends TradeBase
```
- Drain service specializations
- Water damage prevention tips
- Pipe material guide
- Water heater sizing calculator
- Leak detection service highlight
- Fixture galleries
- Water conservation calculator
- Emergency shut-off guide

#### HVAC-Specific
```php
class HVAC extends TradeBase
```
- Heating/cooling service split
- Seasonal maintenance scheduler
- Energy efficiency ratings
- BTU/tonnage calculator
- Air quality services
- Maintenance plan manager
- Temperature zone planner
- Filter reminder system

#### Construction-Specific
```php
class Construction extends TradeBase
```
- Project phase tracker
- Permit management system
- Subcontractor directory
- Material calculator
- Progress photo galleries
- Change order system
- Safety compliance tracker
- Project timeline display

#### Handyman-Specific
```php
class Handyman extends TradeBase
```
- Task-based pricing display
- Honey-do list builder
- Small job aggregator
- Time estimation tool
- Multi-skill showcase
- Property maintenance scheduler
- Seasonal task reminders
- Tool/equipment showcase

### 3.4 Integrations

#### Third-Party Service Integrations
- **Google Services**
	- Google My Business API
	- Google Reviews display
	- Google Maps/Places
	- Google Calendar

- **CRM Systems**
	- ServiceTitan API
	- Jobber integration
	- Housecall Pro
	- Custom webhook support

- **Payment Systems**
	- Stripe payments
	- PayPal integration
	- Square appointments
	- Financing options (Synchrony, etc.)

- **Communication**
	- Twilio SMS notifications
	- WhatsApp Business API
	- Facebook Messenger
	- Live chat integration

- **Email Marketing**
	- Mailchimp
	- Constant Contact
	- ActiveCampaign
	- Custom SMTP

- **Review Platforms**
	- Google Reviews
	- Yelp integration
	- Facebook Reviews
	- BBB ratings

### 3.5 Admin Features

#### Plugin Dashboard
- Quick stats overview
- Recent inquiries
- Appointment calendar view
- Review monitoring
- Performance metrics
- Quick actions menu

#### Settings Management
- General settings
- Trade-specific options
- Integration configurations
- Email templates
- Notification settings
- License management

#### Demo Import System
- One-click demo import
- Content mapping
- Image import options
- Selective import
- Reset functionality
- Child theme detection

#### Data Export/Import
- Settings export/import
- Content backup
- Migration tools
- Child theme generator

## 4. Development Standards

### 4.1 PHP Standards (Matching Theme)

#### Strict Type Requirements
```php
<?php
declare(strict_types=1);

namespace RevoluxCore\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Service_Grid extends Widget_Base {
    /**
     * Get widget name.
     *
     * @since  0.1.0
     * @access public
     * @return string Widget name.
     */
    public function get_name(): string {
        return 'revolux-service-grid';
    }
    
    /**
     * Register widget controls.
     *
     * @since  0.1.0
     * @access protected
     * @return void
     */
    protected function register_controls(): void {
        // Implementation
    }
    
    /**
     * Render widget output.
     *
     * @since  0.1.0
     * @access protected
     * @return void
     */
    protected function render(): void {
        // Implementation
    }
}
```

### 4.2 Elementor Widget Standards

#### Widget Registration Pattern
```php
public function register_widgets(): void {
    // Check if Elementor is active
    if (!did_action('elementor/loaded')) {
        return;
    }
    
    // Register widget categories
    add_action('elementor/elements/categories_registered', [$this, 'register_categories']);
    
    // Register widgets
    add_action('elementor/widgets/register', [$this, 'init_widgets']);
}
```

#### Widget File Structure
- One widget per file
- Consistent naming convention
- Proper control sections
- Responsive controls
- Style/content separation

### 4.3 Custom Post Type Standards

#### Registration Pattern
```php
public function register_service_post_type(): void {
    $labels = [
        'name'                  => _x('Services', 'Post type general name', 'revolux-core'),
        'singular_name'         => _x('Service', 'Post type singular name', 'revolux-core'),
        // ... other labels
    ];
    
    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'services'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'       => true, // Gutenberg support
    ];
    
    register_post_type('revolux_service', $args);
}
```

### 4.4 Security Standards

#### Data Validation
- Strict input validation
- Output escaping
- Nonce verification
- Capability checks
- SQL injection prevention

#### API Security
- Rate limiting
- Authentication tokens
- Encrypted data transfer
- Audit logging

### 4.5 Performance Standards

#### Asset Loading
- Conditional widget asset loading
- Minified production assets
- Lazy loading for images
- Efficient database queries
- Transient caching

#### Code Optimization
- Avoid redundant queries
- Use WordPress object cache
- Optimize Elementor renders
- Efficient AJAX handlers

## 5. Database Schema

### Custom Tables (Optional for Advanced Features)
```sql
-- Appointments table
CREATE TABLE {$wpdb->prefix}revolux_appointments (
    id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    customer_name varchar(255) NOT NULL,
    customer_email varchar(255) NOT NULL,
    customer_phone varchar(20),
    service_id bigint(20) UNSIGNED,
    staff_id bigint(20) UNSIGNED,
    appointment_date datetime NOT NULL,
    duration int(11) NOT NULL,
    status varchar(20) DEFAULT 'pending',
    notes text,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY service_id (service_id),
    KEY staff_id (staff_id),
    KEY appointment_date (appointment_date)
);

-- Service areas table
CREATE TABLE {$wpdb->prefix}revolux_service_areas (
    id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    area_name varchar(255) NOT NULL,
    zip_codes text,
    coordinates text,
    surcharge decimal(10,2),
    is_active tinyint(1) DEFAULT 1,
    PRIMARY KEY (id)
);
```

### Meta Structure
Use WordPress postmeta for most data, custom tables only for:
- High-volume transactional data
- Complex relational data
- Performance-critical queries

## 6. Integration Requirements

### 6.1 Theme Integration

#### Dependency Check
```php
public function check_dependencies(): bool {
    // Check if theme is active
    $theme = wp_get_theme();
    if ($theme->get('TextDomain') !== 'revolux' && $theme->get('Template') !== 'revolux') {
        add_action('admin_notices', [$this, 'theme_required_notice']);
        return false;
    }
    
    // Check Elementor
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', [$this, 'elementor_required_notice']);
        return false;
    }
    
    return true;
}
```

#### Graceful Degradation
- Functions work without theme but with limited styling
- Admin notices for missing dependencies
- Fallback templates for CPTs
- Basic styles included for standalone use

### 6.2 Elementor Integration

#### Version Compatibility
- Support Elementor 3.5+
- Compatibility with Elementor Pro
- Use Elementor's API properly
- Follow Elementor coding standards

#### Widget Dependencies
- Check for Elementor before loading
- Proper widget registration
- Asset enqueueing via Elementor hooks
- Responsive control implementation

## 7. Testing Requirements

### 7.1 Unit Testing
- PHPUnit test suite
- Widget render tests
- CPT registration tests
- Shortcode output tests
- AJAX handler tests

### 7.2 Integration Testing
- Theme + Plugin integration
- Elementor compatibility
- Third-party plugin conflicts
- Multisite compatibility
- PHP 8.0-8.3 testing

### 7.3 Performance Testing
- Query performance
- Asset loading impact
- Memory usage monitoring
- Database query optimization

## 8. Documentation Requirements

### 8.1 User Documentation
- Installation guide
- Widget usage tutorials
- CPT management guide
- Trade-specific feature guides
- Integration setup guides
- Video tutorials

### 8.2 Developer Documentation
- Hook reference
- Filter documentation
- Widget API documentation
- CPT template hierarchy
- Translation guide
- Child theme compatibility

### 8.3 API Documentation
- REST API endpoints
- AJAX handlers
- JavaScript events
- PHP filters/actions
- Database schema

## 9. Deployment Strategy

### 9.1 Version Management
- Semantic versioning
- Changelog maintenance
- Upgrade notices
- Breaking change documentation

### 9.2 Update Mechanism
- Auto-update capability
- License verification
- Rollback functionality
- Database migration handling

### 9.3 Distribution
- Bundled with theme purchase
- Separate license for extended features
- GitHub updater compatible
- Envato Market plugin compatible

## 10. Premium Features (Future)

### 10.1 Advanced Booking System
- Complex scheduling rules
- Resource management
- Payment processing
- Customer accounts
- Automated reminders

### 10.2 Customer Portal
- Account management
- Service history
- Document access
- Payment history
- Appointment management

### 10.3 Advanced Analytics
- Service performance metrics
- Revenue analytics
- Customer insights
- Team performance
- ROI tracking

### 10.4 White Label Options
- Rebranding capabilities
- Agency license features
- Multi-site management
- Bulk license management

## 11. Implementation Priorities

### Phase 1: Core Foundation (Week 1-2)
1. Plugin architecture setup
2. Autoloader implementation
3. Basic CPT registration (Services, Projects)
4. Essential taxonomies
5. Template system

### Phase 2: Elementor Integration (Week 3-4)
1. Widget manager setup
2. Core business widgets (Services, Projects, Team)
3. Contact/CTA widgets
4. Basic styling system
5. Widget templates

### Phase 3: Trade Features (Week 5-6)
1. Trade base class
2. 2-3 trade implementations
3. Trade-specific widgets
4. Demo content preparation
5. Import system

### Phase 4: Advanced Features (Week 7-8)
1. Form builders
2. Booking system basics
3. Integration foundations
4. Admin dashboard
5. Performance optimization

## 12. Code Examples

### 12.1 Main Plugin Class Structure
```php
<?php
declare(strict_types=1);

namespace RevoluxCore;

/**
 * Main plugin class.
 *
 * Singleton pattern implementation for plugin initialization.
 *
 * @since 0.1.0
 */
final class Plugin {
    /**
     * Plugin instance.
     *
     * @since  0.1.0
     * @access private
     * @var    Plugin|null
     */
    private static ?Plugin $instance = null;
    
    /**
     * Plugin version.
     *
     * @since  0.1.0
     * @access private
     * @var    string
     */
    private string $version = '0.1.0';
    
    /**
     * Get plugin instance.
     *
     * @since  0.1.0
     * @access public
     * @static
     * @return Plugin
     */
    public static function instance(): Plugin {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Constructor.
     *
     * @since  0.1.0
     * @access private
     */
    private function __construct() {
        $this->define_constants();
        $this->init_hooks();
    }
    
    /**
     * Define plugin constants.
     *
     * @since  0.1.0
     * @access private
     * @return void
     */
    private function define_constants(): void {
        define('REVOLUX_CORE_VERSION', $this->version);
        define('REVOLUX_CORE_PATH', plugin_dir_path(__FILE__));
        define('REVOLUX_CORE_URL', plugin_dir_url(__FILE__));
    }
    
    /**
     * Initialize hooks.
     *
     * @since  0.1.0
     * @access private
     * @return void
     */
    private function init_hooks(): void {
        add_action('init', [$this, 'init']);
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }
}
```

### 12.2 Widget Base Class Example
```php
<?php
declare(strict_types=1);

namespace RevoluxCore\Elementor\Widgets;

use Elementor\Widget_Base;

/**
 * Base widget class.
 *
 * Extended by all Revolux widgets for common functionality.
 *
 * @since 0.1.0
 */
abstract class Base_Widget extends Widget_Base {
    /**
     * Get widget categories.
     *
     * @since  0.1.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories(): array {
        return ['revolux-elements'];
    }
    
    /**
     * Get widget keywords.
     *
     * @since  0.1.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords(): array {
        return ['revolux', 'trade', 'business'];
    }
    
    /**
     * Register common controls.
     *
     * @since  0.1.0
     * @access protected
     * @return void
     */
    protected function register_common_controls(): void {
        // Implementation of common controls
    }
}
```

## 13. Success Metrics

### 13.1 Technical Metrics
- Zero critical bugs at launch
- <500ms widget render time
- <100ms AJAX response time
- 95%+ code coverage (tests)

### 13.2 User Metrics
- <5 min setup time for basic features
- 90%+ user satisfaction rating
- <2% support ticket rate
- 50%+ feature adoption rate

### 13.3 Business Metrics
- Increase theme value proposition
- Enable premium version potential
- Reduce support burden via automation
- Enable recurring revenue model

## 14. Risk Mitigation

### 14.1 Technical Risks
- **Elementor API Changes**: Version compatibility layer
- **WordPress Updates**: Continuous testing pipeline
- **Performance Impact**: Lazy loading and optimization
- **Database Growth**: Cleanup routines and optimization

### 14.2 User Experience Risks
- **Complexity**: Progressive disclosure of features
- **Learning Curve**: Comprehensive documentation
- **Overwhelm**: Smart defaults and presets

### 14.3 Business Risks
- **Support Burden**: Self-service documentation
- **Feature Creep**: Strict scope management
- **Competition**: Unique trade focus

## 15. Conclusion

The Revolux Core plugin serves as the functional backbone of the Revolux theme ecosystem, providing all custom functionality while maintaining clean separation of concerns. By consolidating related features into well-organized classes and following strict typing standards, we ensure maintainability and professional code quality.

The plugin's architecture supports both immediate needs and future growth, with clear extension points for premium features and third-party integrations. The focus on trade-specific features provides clear differentiation in the market while the modular approach allows for continuous improvement without disrupting existing installations.

---

**Document Version**: 1.0.0  
**Last Updated**: November 2024  
**Status**: Active Development  
**Dependencies**: Revolux Theme PRD v1.0.0
