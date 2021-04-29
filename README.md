<p align="center">
    <a href="https://kasko.io" target="_blank">
        <img src="./web/images/kasko.png" height="200px">
    </a>
    <h1 align="center">IBAN validation task</h1>
    <br>
</p>

Iban validator is graphql API, which is built using the Yii2 framework. You can pass the IBAN code as an input, which gets validated. If validation fails, you get a response with error details (e.g "The length of the given Iban is not valid!"). If validation success response holds IBAN details and information about the country associated with it.

It is built using Docker, which makes it very easy to run application on any enviroument.

Get Docker and docker-compose  [here](https://www.docker.com/products/container-runtime). Start the application with a single command on any os - no need for setup (Except Docker itself, of course).

Recomneded tool to make graphql queries is Insomina, which can be downloaded here [Insomnia](https://insomnia.rest/).
 

