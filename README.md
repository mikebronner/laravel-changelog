# Changelog for Laravel

![Changelog for Laravel masthead image.](https://repository-images.githubusercontent.com/189888584/d096b800-f298-11e9-977e-e6e3925132ae)

Easily integrate and display your changelog in your app.

## Version Support

| Laravel | PHP      |
|---------|----------|
| 11.x    | 8.2+     |
| 12.x    | 8.2+     |
| 13.x    | 8.3+     |

## Routes

| Route | Description |
|-------|-------------|
| `/changelog` | Displays the full changelog grouped by minor version |
| `/changelog/{major}.{minor}` | Deep-links to a specific minor version group (e.g., `/changelog/1.0`) |

The minor version route opens with that version group expanded and scrolled into view.
