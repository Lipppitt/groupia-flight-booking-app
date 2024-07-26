export function useHelpers() {
    const getFormattedDate = (dateTime) => {
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

    const getCurrencySymbolFromString = (currencyString) => {
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
