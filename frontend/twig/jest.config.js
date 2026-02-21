module.exports = {
    testEnvironment: 'jsdom',
    roots: ['<rootDir>/tests'],
    moduleFileExtensions: ['js', 'jsx'],
    testMatch: ['**/*.test.js', '**/*.spec.js'],
    collectCoverageFrom: [
        'assets/**/*.js',
        '!assets/**/*.test.js',
    ],
    coverageDirectory: 'coverage',
    coverageReporters: ['text', 'lcov', 'html'],
    setupFilesAfterEnv: ['<rootDir>/tests/setupJest.js'],
};
