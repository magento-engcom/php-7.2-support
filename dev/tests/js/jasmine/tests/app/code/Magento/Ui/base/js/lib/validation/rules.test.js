/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* eslint-disable max-nested-callbacks */
define([
    'Magento_Ui/js/lib/validation/rules'
], function (rules) {
    'use strict';

    describe('Magento_Ui/js/lib/validation/rules', function () {
        describe('"range-words" method', function () {
            it('Check on empty value', function () {
                var value = '',
                    params = [1,3];

                expect(rules['range-words'].handler(value, params)).toBe(false);
            });

            it('Check on redundant words', function () {
                var value = 'a b c d',
                    params = [1,3];

                expect(rules['range-words'].handler(value, params)).toBe(false);
            });

            it('Check with three words', function () {
                var value = 'a b c',
                    params = [1,3];

                expect(rules['range-words'].handler(value, params)).toBe(true);
            });

            it('Check with one word', function () {
                var value = 'a',
                    params = [1,3];

                expect(rules['range-words'].handler(value, params)).toBe(true);
            });
        });
    });

    describe('validate-color', function () {
        it('Should accept empty value', function () {
            expect(rules['validate-color'].handler('', null)).toEqual(true);
        });

        it('Should not accept invalid value', function () {
            expect(rules['validate-color'].handler('#FF')).toEqual(false);
            expect(rules['validate-color'].handler('#GGG')).toEqual(false);
        });

        it('Should accept hex value', function () {
            expect(rules['validate-color'].handler('#FFF')).toEqual(true);
            expect(rules['validate-color'].handler('#FFFFFF')).toEqual(true);
            expect(rules['validate-color'].handler('FFFFFF')).toEqual(true);
            expect(rules['validate-color'].handler('FFF')).toEqual(true);
        });

        it('Should accept English color value', function () {
            expect(rules['validate-color'].handler('red')).toEqual(true);
            expect(rules['validate-color'].handler('BLuE')).toEqual(true);
            expect(rules['validate-color'].handler(' GReEn     ')).toEqual(true);
        });

        it('Should accept rgb(a) value', function () {
            expect(rules['validate-color'].handler('rgb(128, 128, 10)')).toEqual(true);
            expect(rules['validate-color'].handler('rgb(255, 0, 57, 0.4)')).toEqual(true);
        });

        it('Should accept hsl(a) value', function () {
            expect(rules['validate-color'].handler('hsl(0, 100, 50)')).toEqual(true);
            expect(rules['validate-color'].handler('hsl(40, 75%, 25%)')).toEqual(true);
            expect(rules['validate-color'].handler('hsl(50, 25, 50, 50)')).toEqual(true);
        });

        it('Should accept hsv value', function () {
            expect(rules['validate-color'].handler('hsv(0, 100, 100)')).toEqual(true);
            expect(rules['validate-color'].handler('hsv(25, 25%, 65%)')).toEqual(true);
        });
    });
});
