Feature: Create proxy trunks
  In order to manage proxy trunks
  as a super admin
  I need to be able to create them through the API.

  @createSchema
  Scenario: Create a proxy trunk
    Given I add Authorization header
     When I add "Content-Type" header equal to "application/json"
      And I add "Accept" header equal to "application/json"
      And I send a "POST" request to "/proxy_trunks" with body:
      """
      {
          "name": "proxyTrunkPlatform1",
          "ip": "0.0.0.0"
      }
      """
     Then the response status code should be 201
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be equal to:
      """
      {
        "name": "proxyTrunkPlatform1",
        "ip": "0.0.0.0",
        "id": 3
      }
      """

  Scenario: Retrieve created proxy trunk rel brand
    Given I add Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "proxy_trunks/3"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be equal to:
      """
      {
        "name": "proxyTrunkPlatform1",
        "ip": "0.0.0.0",
        "id": 3
      }
      """
