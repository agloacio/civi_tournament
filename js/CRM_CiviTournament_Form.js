function escapeSelector(selector) {
    return selector.replace(/\./g, '\\.');
}

let CRM_CiviTournament_Form = {
    loadStates: function (countryId, stateSelectId) {
        parameters = {
            select: ["name"],
            where: [["country_id", "=", countryId]]
        };

        CRM.api4('StateProvince', 'get', parameters).then(function (result) {
            const $stateSelect = CRM.$('#' + escapeSelector(stateSelectId));
                $stateSelect.empty();

                // Add state options
                result.forEach(function (state) {
                    $stateSelect.append(CRM.$('<option>', {
                        value: state.id,
                        text: state.name
                    }));
                });
            })
            .catch(function (error) {
                console.error('Error fetching states:', error);
                // Optionally display an error message to the user
            });
    }
};