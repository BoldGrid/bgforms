# BoldGrid Forms

The BoldGrid Forms shared classes are used in official BoldGrid plugins.

Using composer, you can get started quickly:

```php
composer require boldgrid/bgforms

```

## Changelog ##

### 1.2.3 ###
* Update: Fix PHP 8.2 Deprecation notices.

### 1.2.2 ###
* Update: Use internal method to get_page_by_title() since WP6.2 deprecated the function.

### 1.2.1 ###
* Update: Allow weforms shortcodes to have their form id replaced with the imported form id.

### 1.2.0 ###
* New feature: Added support for weForms.

### 1.1.5 ###
* Update: Prevent wpforms redirection immediately after Inspirations deployment in all scenarios.

### 1.1.4 ###
* Update:       JIRA WPB-3730   Updated library dependency to ^2.0.0.

### 1.1.3 ###
* Bug fix: Fixed improper namespace resolution for Wpforms\Tracking class.
* Update:  Updated URL for Wpforms\Tracking to remove class dependency.

### 1.1.2 ###
* Bug fix:      JIRA WPB-3401   Fixed fatal when plugin was deleted.

### 1.1.1 ###
* Update:       JIRA WPB-3401   Adding affiliate data.

### 1.1.0 ###
* Update:       JIRA WPB-3400   Prevent WPForms welcome page.

### 1.0.1 ###
* Bug fix:      JIRA WPB-3318   When forcing a preferred form plugin install, first check if plugin is installed before trying to activate.
* New feature:  JIRA WPB-3312   Added filter for preferred slug.

### 1.0.0 ###
* Initial commit.
