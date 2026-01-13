---
applyTo: "**/*.css"
---

# CSS-Specific Instructions

## Code Style

- Use consistent indentation (2 or 4 spaces, match existing files)
- One selector per line for multi-selector rules
- Add a space after `:` in property declarations
- Use lowercase for property names and values
- Add a semicolon after every declaration (even the last one)
- Group related properties together
- Order properties logically (positioning, box model, typography, visual, misc)

## Naming Conventions

- Use descriptive, semantic class names
- Use kebab-case for class names (e.g., `file-card`, `download-button`)
- Avoid overly generic names (not just `button` or `container`)
- Prefix state classes with a verb (e.g., `is-active`, `has-error`)
- Keep specificity low - avoid unnecessary nesting

## Responsive Design

- Mobile-first approach (base styles for mobile, media queries for larger screens)
- Use relative units (rem, em, %) over fixed pixels when appropriate
- Test on common breakpoints (mobile, tablet, desktop)
- Use flexbox and CSS Grid for layouts
- Ensure touch targets are at least 44x44px for mobile

## Browser Compatibility

- Use modern CSS features (flexbox, grid) as they're well-supported
- Provide fallbacks for experimental features
- Test in major browsers (Chrome, Firefox, Safari, Edge)
- Consider mobile browsers (Safari iOS, Chrome Android)

## Performance

- Minimize use of expensive properties (box-shadow, gradients on large areas)
- Avoid unnecessary animations on low-end devices
- Use CSS transforms for animations (better performance)
- Optimize for render performance

## Design System

- Use CSS custom properties (variables) for:
  - Colors (maintain consistency)
  - Spacing values
  - Font sizes
  - Common values used multiple times
- Respect existing color schemes and design patterns
- Maintain visual consistency with the rest of the application

Example:
```css
:root {
    --primary-color: #A0D8FA;
    --text-color: #333;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 2rem;
}
```

## Layout Patterns

- Use flexbox for one-dimensional layouts
- Use CSS Grid for two-dimensional layouts
- Prefer semantic HTML structure over excessive divs
- Use CSS to handle spacing, not empty elements

## Typography

- Use rem units for font sizes (scalable)
- Maintain readable line lengths (45-75 characters)
- Ensure sufficient line height (1.4-1.6 for body text)
- Use web fonts consistently (Inter, Montserrat as per project)

## Colors and Theming

- Use CSS variables for theme colors
- Ensure sufficient contrast for accessibility (WCAG AA minimum)
- Use the theme color defined: `#A0D8FA` for primary elements
- Maintain color consistency across the application

## Accessibility

- Ensure focus states are visible and clear
- Don't rely solely on color to convey information
- Test keyboard navigation
- Ensure sufficient color contrast
- Use appropriate semantic markup (this is primarily an HTML concern, but affects CSS)

## Component-Specific Styling

- Keep component styles scoped and specific
- Avoid global styles that might have unintended effects
- Use specific class names rather than element selectors when possible
- Organize styles by component or page

## Animations and Transitions

- Use CSS transitions for interactive elements (hover, focus states)
- Keep animations subtle and purposeful
- Use `prefers-reduced-motion` media query for accessibility
- Prefer transform and opacity for animations (GPU-accelerated)

Example:
```css
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0s !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0s !important;
    }
}
```

## File Organization

- Keep related styles together in the same file
- Use clear section comments for organization
- Follow the existing file structure (style.css, header-simple.css, etc.)
- Consider splitting large stylesheets by component or page
