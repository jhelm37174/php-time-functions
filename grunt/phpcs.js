module.exports = function (grunt) {
  return {

    application: {
      dir: ['src/*.php', 'tests/*.php']
    },
    options: {
        bin: 'phpcs',
        standard: 'Zend'
    }

  };
};
