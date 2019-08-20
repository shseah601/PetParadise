<html>

<head>
  <title>Registration Email</title>
</head>

<body>
  <table>
    <tr>
      <td>Dear {{ $name }},</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        Your account has been successfully created. <br />
        Your account information is as below:
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Email: {{$email}}</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Password: ***** (as chosen by you)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Thanks for your joining.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Regards,</td>
    </tr>
    <tr>
      <td>PetParadise</td>
    </tr>
  </table>
</body>

</html>