<?php

/**
 * Authentication adapter for Github OAuth2.
 */
final class PhutilPoniverseAuthAdapter extends PhutilOAuthAuthAdapter {

  public function getAdapterType() {
    return 'poniverse';
  }

  public function getAdapterDomain() {
    return 'poniverse.net';
  }

  public function getAccountID() {
    return $this->getOAuthAccountData('id');
  }

  public function getAccountEmail() {
    return $this->getOAuthAccountData('email');
  }

  public function getAccountName() {
    return $this->getOAuthAccountData('username');
  }

  public function getAccountImageURI() {
    return null;
  }

  public function getAccountURI() {
    return null;
  }

  public function getAccountRealName() {
    return null;
  }

  protected function getAuthenticateBaseURI() {
    return 'https://poniverse.net/oauth/authorize';
  }

  protected function getTokenBaseURI() {
    return 'https://poniverse.net/oauth/access_token';
  }

  public function getExtraRefreshParameters() {
      return ['grant_type' => 'refresh_token'];
  }

  public function getExtraAuthenticateParameters() {
      return ['response_type' => 'code'];
  }

 public function getExtraTokenParameters() {
      return ['grant_type' => 'authorization_code'];
  }

  public function supportsTokenRefresh() {
      return true;
  }

  protected function loadOAuthAccountData() {
    $uri = new PhutilURI('https://api.poniverse.net/v1/users/me');
    $uri->setQueryParam('access_token', $this->getAccessToken());


    $future = new HTTPSFuture($uri);


    list($body) = $future->resolvex();

    $data = json_decode($body, true);
    if (!is_array($data)) {
      throw new Exception(
        "Expected valid JSON response from Poniverse account data request, ".
        "got: ".$body);
    }

    return $data;
  }

}
