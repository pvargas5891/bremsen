import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'currencyFormat'
})
export class CurrencyFormatPipe implements PipeTransform {

  transform(value: string,
        currencySign: string = '$ ',
        decimalLength: number = 0,
        chunkDelimiter: string = '.',
        decimalDelimiter:string = '.',
        chunkLength: number = 2): string {
        console.debug(value);
        //value /= 100;
        return currencySign+' '+value.replace(',','.');
       // let result = '\\d(?=(\\d{' + chunkLength + '})+' + (decimalLength > 0 ? '\\D' : '$') + ')'
       //// let num = value.toFixed(Math.max(0, ~~decimalLength));

       // return currencySign+(decimalDelimiter ? num.replace('.', decimalDelimiter) : num).replace(new RegExp(result, 'g'), '$&' + chunkDelimiter);
    }

}
