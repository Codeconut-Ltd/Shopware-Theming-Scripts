const { join, resolve } = require('path');

const isHotMode = process.env.MODE === 'hot';

module.exports = () => {
    return {
        resolve: {
            alias: {
                ccn: resolve(join(__dirname, '..', 'env', isHotMode ? 'hot' : 'default')),
            },
        },
    };
};
