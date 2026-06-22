pipeline {

## agent any means run the pipeline on the Jenkins server itself

        agent any

## ── ENVIRONMENT VARIABLES ────────────────────────────────────
## These variables are available in every stage below
## withCredentials pulls from Jenkins credential store (not plain text)

environment {

## Your Docker Hub username
        
        DOCKER_USER = 'priyankadockrs'

## Image name
        IMAGE_NAME = 'priyankadockrs/employee-app'

## BUILD_NUMBER is auto-provided by Jenkins: 1, 2, 3...
        
        IMAGE_TAG = "build-${BUILD_NUMBER}"

## This pulls password from Jenkins credential store

        DOCKER_CREDENTIALS = credentials('dockerhub-credentials')
}

stages {

## ── STAGE 1 ──────────────────────────────────────────────

        stage('Checkout Code')
 {
        steps {

## Pull latest code from GitHub
## Jenkins automatically knows the repo from job config checkout scm
## Print current directory and list files
## Good for confirming code was checked out correctly

        sh 'pwd'
        sh 'ls -la'
        sh 'echo Code checkout complete'
}
}

## ── STAGE 2 ──────────────────────────────────────────────
  stage('Build Docker Image') {
                steps {
        sh '''
        echo Building Docker image...

# Build with both latest and build-number tags

        docker build -t priyankadockrs/employee-app:latest -t priyankadockrs/employee-app:v1.0 .
        echo Image build complete docker images | grep employee-app
'''
}
}


## ── STAGE 3 ──────────────────────────────────────────────

        stage('Push to Docker Hub') {
        steps {
        sh '''
        echo Logging in to Docker Hub...
## DOCKER_CREDENTIALS_USR and DOCKER_CREDENTIALS_PSW
## are automatically created from the credentials() binding
        echo $DOCKER_CREDENTIALS_PSW | \
        docker login \
        --username $DOCKER_CREDENTIALS_USR \
        --password-stdin

        echo Pushing images...
        docker push $priyankadockrs/employee-app:latest
        docker push $priyankadockrs/employee-app:$V1.0
        echo Push complete
'''
}
}

## ── STAGE 4 ──────────────────────────────────────────────

        stage('Deploy Application') {
        steps {
        sh '''
        echo Deploying application...

## Navigate to app directory
        
        cd /home/ubuntu/employee-app

# Pull latest image

        docker compose pull

# Restart container with new image

        docker compose up -d --remove-orphans
        echo Deployment complete
'''
}
}

## ── STAGE 5 ──────────────────────────────────────────────

        stage('Verify Deployment') {
        steps {
        sh '''
        echo Verifying deployment...

## Wait for container to be fully up
        sleep 10

# Check container is running
        docker ps | grep employee-app

# Test HTTP response
        curl -I http://localhost
        echo Verification complete - app is running!
'''
}
}
}

## ── POST ACTIONS ─────────────────────────────────────────────
## These run after ALL stages complete
        
        post {

## Always runs — even if build failed
        
        always {
        sh '''
        echo Cleaning up Docker login session...
        docker logout
'''
}


## Only runs if all stages passed
        
        success {
        echo 'Pipeline completed successfully!'
        echo 'Application deployed and verified.'
}


## Only runs if any stage failed
        
        failure {
        echo 'Pipeline FAILED!'
        echo 'Check Console Output for error details.'
}
}
}
