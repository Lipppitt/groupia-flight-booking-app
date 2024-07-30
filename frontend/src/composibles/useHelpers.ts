export function useHelpers() {
    const getFormattedDate = (dateTime: string) => {
        const date = new Date(dateTime);
        return date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
        });
    }

    const getCurrencySymbolFromString = (currencyString: string) => {
        switch (currencyString) {
            case 'EUR' :
                return '€';
        }
    }

    return {
        getFormattedDate,
        getCurrencySymbolFromString
    }
}
