pipeline {
    agent any

    environment {
        // Docker Hub username
        DOCKER_USER = 'priyankadockrs'

        // Image name
        IMAGE_NAME = 'priyankadockrs/employee-app'

        // BUILD_NUMBER is auto-provided by Jenkins
        IMAGE_TAG = "build-${BUILD_NUMBER}"

        // Credentials binding from Jenkins store
        DOCKER_CREDENTIALS = credentials('dockerhub-credentials')
    }

    stages {
        stage('Checkout Code') {
            steps {
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
        success {
            echo 'Pipeline completed successfully!'
            echo 'Application deployed and verified.'

	// ✅ Email notification on success
            emailext(
                subject: "SUCCESS: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                body: """
                Job Name: ${env.JOB_NAME}
                Build Number: ${env.BUILD_NUMBER}
                Build Status: SUCCESS
                """,
                to: "ptechvishwa@gmail.com"
            )
        }

        failure {
            echo 'Pipeline FAILED!'
            echo 'Check Console Output for error details.'
        }
    }
}
