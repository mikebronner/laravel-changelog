Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'laravel-changelog',
            path: '/laravel-changelog',
            component: require('./components/Tool'),
        },
    ])
})
