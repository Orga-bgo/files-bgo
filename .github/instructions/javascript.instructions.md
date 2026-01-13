---
applyTo: "**/*.js"
---

# JavaScript-Specific Instructions

## Code Style

- Use modern ES6+ syntax (const/let, arrow functions, template literals)
- Prefer `const` by default, use `let` only when reassignment is needed, never use `var`
- Use arrow functions for callbacks and short functions
- Use template literals for string interpolation
- Use destructuring when it improves readability

## Vanilla JavaScript

- This project uses vanilla JavaScript with no frameworks
- Avoid adding dependencies unless absolutely necessary
- Use native DOM APIs (`querySelector`, `addEventListener`, etc.)
- Prefer modern browser APIs over polyfills
- Ensure backwards compatibility with recent browser versions

## DOM Manipulation

- Cache DOM queries when elements are accessed multiple times
- Use event delegation for dynamic content
- Remove event listeners when they're no longer needed
- Prefer `textContent` over `innerHTML` unless HTML is needed
- Sanitize any user-generated content before inserting into the DOM

## Event Handling

- Use `addEventListener` for attaching events (not inline handlers)
- Use event delegation for dynamic elements
- Prevent default behavior explicitly when needed
- Name event handler functions descriptively

## Async Operations

- Use `async/await` for asynchronous code (preferred over `.then()`)
- Handle errors with try/catch blocks
- Use `fetch` API for HTTP requests
- Always check response status before processing

## API Calls

- Use fetch with proper error handling
- Include CSRF tokens when making state-changing requests
- Parse JSON responses safely with try/catch
- Show user feedback for loading states and errors

Example:
```javascript
async function submitForm(formData) {
    try {
        const response = await fetch('/api/endpoint.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        if (!response.ok) {
            throw new Error('Request failed');
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error:', error);
        // Show user-friendly error message
    }
}
```

## Progressive Web App (PWA)

- When modifying `sw.js` (service worker):
  - Update version number when changing cached resources
  - Test offline functionality
  - Handle cache updates gracefully
  - Clean up old caches

## Code Organization

- Keep related functionality together
- Use clear, descriptive function and variable names
- Avoid deeply nested code (max 3-4 levels)
- Extract complex logic into separate functions
- Add comments for non-obvious logic

## Performance

- Minimize DOM manipulations
- Use document fragments for multiple insertions
- Debounce or throttle frequent events (scroll, resize, input)
- Lazy load images and heavy resources when appropriate

## Security

- Validate and sanitize any user input
- Use textContent instead of innerHTML when displaying user data
- Avoid `eval()` and similar dangerous functions
- Be cautious with dynamic script insertion

## Browser Compatibility

- Test in modern browsers (Chrome, Firefox, Safari, Edge)
- Use feature detection when needed
- Provide fallbacks for critical functionality
- Consider mobile Safari and Chrome mobile
