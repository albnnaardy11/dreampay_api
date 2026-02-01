# GitHub Pages Configuration

This file ensures GitHub Pages serves the documentation correctly.

## Current Configuration

- **Repository:** albnnaardy11/dreampay_api
- **Branch:** gh-pages
- **URL:** https://albnnaardy11.github.io/dreampay_api/
- **Base URL:** /dreampay_api/

## Setup Instructions

1. Go to repository Settings → Pages
2. Set Source to "Deploy from a branch"
3. Select branch: `gh-pages`
4. Select folder: `/ (root)`
5. Click Save

## Verification

After deployment, verify:
- [ ] Site is accessible at https://albnnaardy11.github.io/dreampay_api/
- [ ] All pages load correctly
- [ ] Navigation works
- [ ] API documentation is visible
- [ ] Search functionality works

## Troubleshooting

### 404 Error

If you get a 404 error:
1. Check that GitHub Pages is enabled
2. Verify the `gh-pages` branch exists
3. Ensure the branch has content in the root directory
4. Wait a few minutes for GitHub to build and deploy

### CSS/JS Not Loading

If styles or scripts don't load:
1. Check `baseUrl` in `docusaurus.config.ts` matches your repository name
2. Verify `url` is set to `https://albnnaardy11.github.io`
3. Clear browser cache

### Deployment Not Updating

If changes don't appear:
1. Check GitHub Actions workflow completed successfully
2. Verify the `gh-pages` branch was updated
3. Clear browser cache
4. Wait a few minutes for GitHub CDN to update
