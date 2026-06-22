pipeline {
    agent any

    environment {
        // Your Docker Hub username
        DOCKER_USER = 'priyankadockrs'

        // Image name
        IMAGE_NAME = 'priyankadockrs/employee-app'

        // BUILD_NUMBER is auto-provided by Jenkins: 1, 2, 3...
        IMAGE_TAG = "build-${BUILD_NUMBER}"

        // This pulls password from Jenkins credential store
        DOCKER_CREDENTIALS = credentials('dockerhub-credentials')
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Pull latest code from GitHub
                sh 'pwd'
                sh 'ls -la'
                sh 'echo Code checkout complete'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                echo Building Docker image...
                docker build -t $IMAGE_NAME:latest -t $IMAGE_NAME:$IMAGE_TAG .
                echo Image build complete
                docker images | grep employee-app
                '''
            }
        }

        stage('Push to Docker Hub') {
            steps {
                sh '''
                echo Logging in to Docker Hub...
                echo $DOCKER_CREDENTIALS_PSW | docker login -u $DOCKER_CREDENTIALS_USR --password-stdin

                echo Pushing images...
                docker push $IMAGE_NAME:latest
                docker push $IMAGE_NAME:$IMAGE_TAG
                echo Push complete
                '''
            }
        }

        stage('Deploy Application') {
            steps {
                sh '''
                echo Deploying application...
                cd /home/ubuntu/employee-app

                docker compose pull
                docker compose up -d --remove-orphans
                echo Deployment complete
                '''
            }
        }

        stage('Verify Deployment') {
            steps {
                sh '''
                echo Verifying deployment...
                sleep 10

                docker ps | grep employee-app
                curl -I http://localhost
                echo Verification complete - app is running!
                '''
            }
        }
    }

    post {
        always {
            sh '''
            echo Cleaning up Docker login session...
            docker logout
            '''
        }

        success {
            echo 'Pipeline completed successfully!'
            echo 'Application deployed and verified.'
        }

        failure {
            echo 'Pipeline FAILED!'
            echo 'Check Console Output for error details.'
        }
    }
}
