Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'nova-notifications',
            path: '/nova-notifications',
            component: require('./components/Tool'),
        },
    ])
})
