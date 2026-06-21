pipeline {

    agent any

    environment {
        IMAGE_NAME = "priyankadockrs/employee-app"
    }

    stages {

        stage('Clone Repository') {

            steps {

                git branch: 'main', url: 'https://github.com/PriyankaV-cmd/Employee-Database-Project.git'

            }
        }

        stage('Build Docker Image') {

            steps {

                sh 'docker build -t $IMAGE_NAME:latest .'

            }
        }

        stage('Push Docker Image') {

            steps {

                withCredentials([usernamePassword(

                    credentialsId: 'dockerhub-creds',
                    usernameVariable: 'DOCKER_USER',
                    passwordVariable: 'DOCKER_PASS'

                )]) {

                    sh '''
                    echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin

                    docker push $IMAGE_NAME:latest
                    '''
                }
            }
        }
    }

    post {

        success {

            emailext(

                subject: "SUCCESS: ${env.JOB_NAME} #${env.BUILD_NUMBER}",

                body: """
                Job Name: ${env.JOB_NAME}

                Build Number: ${env.BUILD_NUMBER}

                Build Status: SUCCESS
                """,

                to: "yashdagar365@gmail.com"
            )
        }
    }
}
