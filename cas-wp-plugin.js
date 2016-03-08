
function WPService($http) {

	var WPService = {
		categories: [],
		posts: [],
		pageTitle: 'Latest Posts:',
		currentPage: 1,
		totalPages: 1,
		currentUser: {}
	};
	
	//...
	
	WPService.getCurrentUser = function() {
		return $http.get('wp-json/wp/v2/users/me').success(function(res){
			WPService.currentUser = res;
		});
	};

	return WPService;
}


angular.module('backendApp', [])

.config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
	// ...

	$httpProvider.interceptors.push([function() {
		return {
			'request': function(config) {
				config.headers = config.headers || {};
				//add nonce to avoid CSRF issues
				config.headers['X-WP-Nonce'] = myLocalized.nonce;

				return config;
			}
		};
	}]);
}])

.factory('WPService', ['$http', WPService])

.controller('backendCtrl', function($scope, $http, $httpProvider){
  $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school')
    .then(function(response){
    $scope.schools = response.data;
    console.log($scope.schools);
  });
});